export function normalizeText(value) {
  return String(value ?? "")
    .replace(/\s+/g, " ")
    .trim()
    .toLowerCase();
}

export function normalizeKey(value) {
  return normalizeText(value).replace(/[^a-z0-9]/g, "");
}

export function parseNumber(value) {
  if (value === null || value === undefined || value === "") {
    return null;
  }

  let cleaned = String(value).replace(/\s/g, "").replace(/%/g, "").trim();

  if (cleaned.includes(",") && !cleaned.includes(".")) {
    cleaned = cleaned.replace(",", ".");
  } else if (cleaned.includes(".") && cleaned.includes(",")) {
    cleaned = cleaned.replace(/\./g, "").replace(",", ".");
  }

  const number = Number(cleaned);

  return Number.isFinite(number) ? number : null;
}

export function formatNumber(value, decimals = 2) {
  if (value === null || value === undefined || value === "") {
    return "—";
  }

  const number = Number(value);

  if (!Number.isFinite(number)) {
    return "—";
  }

  return new Intl.NumberFormat("id-ID", {
    minimumFractionDigits: 0,
    maximumFractionDigits: decimals,
  }).format(number);
}

export function formatPercent(value) {
  const number = parseNumber(value);

  if (number === null || !Number.isFinite(number)) {
    return "—";
  }

  return `${formatNumber(number, 2)}%`;
}

export function getField(row, fieldNames = []) {
  if (!row || typeof row !== "object") {
    return null;
  }

  const rowKeys = Object.keys(row);

  // Exact field
  for (const field of fieldNames) {
    if (row[field] !== undefined && row[field] !== null && row[field] !== "") {
      return row[field];
    }
  }

  // Normalized field
  const normalizedKeys = rowKeys.map((key) => ({
    original: key,
    normalized: normalizeKey(key),
  }));

  for (const field of fieldNames) {
    const target = normalizeKey(field);

    const found = normalizedKeys.find((item) => item.normalized === target);

    if (
      found &&
      row[found.original] !== undefined &&
      row[found.original] !== null &&
      row[found.original] !== ""
    ) {
      return row[found.original];
    }
  }

  // Partial field
  for (const field of fieldNames) {
    const target = normalizeKey(field);

    if (!target) continue;

    const found = normalizedKeys.find(
      (item) =>
        item.normalized.includes(target) || target.includes(item.normalized),
    );

    if (
      found &&
      row[found.original] !== undefined &&
      row[found.original] !== null &&
      row[found.original] !== ""
    ) {
      return row[found.original];
    }
  }

  return null;
}

export function getRawData(item) {
  if (!item || typeof item !== "object") {
    return null;
  }

  if (item.data_asli && typeof item.data_asli === "object") {
    return item.data_asli;
  }

  return null;
}

export function getSourceName(item) {
  const sourceId = item?.sumber_api_id;

  const sourceMap = {
    1: "Satu Data KLH",
    2: "Satu Data KLH",
    3: "Satu Data KLH",
    4: "Satu Data KLH",
    5: "Satu Data KLH",
    6: "Satu Data KLH",
    7: "InaRISK BNPB",
  };

  return sourceMap[sourceId] || "Laravel + MySQL";
}
