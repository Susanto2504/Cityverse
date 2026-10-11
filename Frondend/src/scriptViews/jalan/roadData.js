export function normalizeGeometry(item) {
  let coords = item?.koordinat_geometri;

  if (typeof coords === "string") {
    try {
      coords = JSON.parse(coords);
    } catch (error) {
      console.error("Geometry tidak valid:", error);
      return [];
    }
  }

  if (!Array.isArray(coords)) {
    return [];
  }

  return coords
    .filter((point) => {
      return (
        Array.isArray(point) &&
        point.length >= 2 &&
        Number.isFinite(Number(point[0])) &&
        Number.isFinite(Number(point[1]))
      );
    })
    .map((point) => [Number(point[0]), Number(point[1])]);
}

export function getRoadSegments(jalan) {
  if (!Array.isArray(jalan?.segmen_jalans)) {
    return [];
  }

  return jalan.segmen_jalans;
}

export function getRoadGeometry(jalan) {
  const result = [];
  const segments = getRoadSegments(jalan);

  for (const segmen of segments) {
    const coords = normalizeGeometry(segmen);

    if (coords.length < 2) {
      continue;
    }

    for (const coord of coords) {
      result.push(coord);
    }
  }

  return result;
}

export function getTotalCapacity(jalan) {
  return getRoadSegments(jalan).reduce(
    (total, segmen) => total + Number(segmen.kapasitas_jalan || 0),
    0,
  );
}

export function getTotalVolume(jalan) {
  return getRoadSegments(jalan).reduce(
    (total, segmen) => total + Number(segmen.volume_kendaraan || 0),
    0,
  );
}

export function getTrafficSummary(jalan) {
  const segments = getRoadSegments(jalan);

  const totalVolume = segments.reduce(
    (total, segmen) => total + Number(segmen.volume_kendaraan || 0),
    0,
  );

  const totalCapacity = segments.reduce(
    (total, segmen) => total + Number(segmen.kapasitas_jalan || 0),
    0,
  );

  if (totalCapacity <= 0) {
    return {
      volume: totalVolume,
      kapasitas: totalCapacity,
      rasio: 0,
      persentase: 0,
      kondisi: "Tidak Diketahui",
    };
  }

  const rasio = totalVolume / totalCapacity;
  const persentase = rasio * 100;

  let kondisi = "Lancar";

  if (persentase > 80) {
    kondisi = "Macet";
  } else if (persentase >= 50) {
    kondisi = "Sedang";
  }

  return {
    volume: totalVolume,
    kapasitas: totalCapacity,
    rasio,
    persentase,
    kondisi,
  };
}
