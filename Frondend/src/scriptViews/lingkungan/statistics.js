import { computed } from "vue";

export function useEnvironmentalStatistics({
  ikuData,
  ikuRows,
  ikaData,
  ikaRows,
  parseNumber,
  formatNumber,
  getField,
}) {
  // =========================
  // IKU / KUALITAS UDARA
  // =========================
  const ikuValue = computed(() => {
    if (!ikuData.value) {
      const item = ikuRows.value[0];
      return parseNumber(item?.nilai);
    }

    const value = getField(ikuData.value, [
      "IKU",
      "Indeks Kualitas Udara",
      "Indeks Kualitas Udara (IKU)",
      "Indeks_Kualitas_Udara",
      "Indeks_Kualitas_Udara_(IKU)",
      "Nilai IKU",
      "Nilai Indeks Kualitas Udara",
      "nilai_iku",
      "nilai_iku_tahun",
      "iku",
      "ISPU",
      "Nilai ISPU",
      "ispu",
    ]);

    return parseNumber(value);
  });

  const ikuDisplay = computed(() => {
    const number = parseNumber(ikuValue.value);
    return number === null ? "—" : formatNumber(number, 2);
  });

  // =========================
  // IKA / KUALITAS AIR
  // =========================
  const ikaValue = computed(() => {
    const item = ikaRows.value[0];

    if (!item) {
      return null;
    }

    if (item.nilai !== null && item.nilai !== undefined) {
      const databaseValue = parseNumber(item.nilai);

      if (databaseValue !== null) {
        return databaseValue;
      }
    }

    const row = ikaData.value;

    if (!row) {
      return null;
    }

    const directFields = [
      "IKA",
      "Indeks Kualitas Air",
      "Indeks Kualitas Air (IKA)",
      "Indeks_Kualitas_Air",
      "Indeks_Kualitas_Air_(IKA)",
      "Indeks Kualitas Air Tahun",
      "Indeks Kualitas Air Tahun 2024",
      "Indeks Kualitas Air (IKA) Tahun 2024",
      "Nilai IKA",
      "Nilai Indeks Kualitas Air",
      "nilai_ika",
      "nilai_ika_tahun",
      "ika",
      "2024",
    ];

    for (const field of directFields) {
      const value = getField(row, [field]);
      const number = parseNumber(value);

      if (number !== null) {
        return number;
      }
    }

    return null;
  });

  const ikaDisplay = computed(() => {
    const number = parseNumber(ikaValue.value);
    return number === null ? "—" : formatNumber(number, 2);
  });

  return {
    ikuValue,
    ikuDisplay,
    ikaValue,
    ikaDisplay,
  };
}

export function useWasteStatistics({
  wasteData,
  achievementData,
  managedData,
  compositionRows,
  parseNumber,
  formatNumber,
  formatPercent,
  getField,
}) {
  // =========================
  // TIMBULAN SAMPAH
  // =========================
  const wasteTotal = computed(() => {
    const value = getField(wasteData.value, [
      "jml_timbulan_tahun",
      "Timbulan Sampah Tahunan (Ton/Tahun)",
      "Timbulan Sampah",
      "Timbulan",
      "timbulan",
      "timbulan_tahun",
    ]);

    if (value !== null && value !== undefined && value !== "") {
      return parseNumber(value);
    }

    return parseNumber(
      getField(achievementData.value, [
        "Timbulan Sampah Tahunan (Ton/Tahun)",
        "Timbulan Sampah",
        "Timbulan",
        "timbulan",
        "timbulan_tahun",
      ]),
    );
  });

  // =========================
  // SAMPAH TERKELOLA
  // =========================
  const wasteManaged = computed(() => {
    const value = getField(achievementData.value, [
      "Sampah Terkelola Tahunan (Ton/Tahun)",
      "Sampah Terkelola",
      "sampah_terkelola",
      "jml_kelola",
      "Jumlah Sampah Terkelola",
    ]);

    if (value !== null && value !== undefined && value !== "") {
      return parseNumber(value);
    }

    return parseNumber(
      getField(wasteData.value, [
        "jml_kelola",
        "Sampah Terkelola",
        "Jumlah Sampah Terkelola",
      ]),
    );
  });

  // =========================
  // PENANGANAN SAMPAH
  // =========================
  const wasteHandling = computed(() => {
    const value = getField(achievementData.value, [
      "Penanganan Sampah Tahunan (Ton/Tahun)",
      "Penanganan Sampah",
      "Penanganan",
      "penanganan",
      "jml_penanganan_tahun",
    ]);

    return parseNumber(
      value ??
        getField(wasteData.value, [
          "jml_penanganan_tahun",
          "Penanganan Sampah",
          "Penanganan",
          "penanganan",
        ]),
    );
  });

  // =========================
  // PENGURANGAN SAMPAH
  // =========================
  const wasteReduction = computed(() => {
    const value = getField(achievementData.value, [
      "Pengurangan Sampah Tahunan (Ton/Tahun)",
      "Pengurangan Sampah",
      "Pengurangan",
      "pengurangan",
      "jml_pengurangan_tahun",
    ]);

    return parseNumber(
      value ??
        getField(wasteData.value, [
          "jml_pengurangan_tahun",
          "Pengurangan Sampah",
          "Pengurangan",
          "pengurangan",
        ]),
    );
  });

  // =========================
  // PERSENTASE SAMPAH TERKELOLA
  // =========================
  const wastePercentage = computed(() => {
    const fields = [
      "% Sampah Terkelola",
      "Persentase Sampah Terkelola",
      "persen_kelola",
      "persen_terkelola",
      "Persentase Terkelola",
      "% Terkelola",
    ];

    return parseNumber(
      getField(managedData.value, fields) ??
        getField(achievementData.value, fields) ??
        getField(wasteData.value, fields),
    );
  });

  // =========================
  // PERSENTASE PENANGANAN
  // =========================
  const wasteHandlingPercentage = computed(() => {
    const fields = [
      "% Penanganan Sampah",
      "Persentase Penanganan Sampah",
      "Penanganan Sampah (%)",
      "persen_penanganan",
      "persentase_penanganan",
      "persen_penanganan_sampah",
    ];

    const apiValue = parseNumber(
      getField(achievementData.value, fields) ??
        getField(wasteData.value, fields),
    );

    if (apiValue !== null) return apiValue;

    const total = wasteTotal.value;
    const handling = wasteHandling.value;

    return total > 0 && handling !== null ? (handling / total) * 100 : 0;
  });

  // =========================
  // PERSENTASE PENGURANGAN
  // =========================
  const wasteReductionPercentage = computed(() => {
    const fields = [
      "% Pengurangan Sampah",
      "Persentase Pengurangan Sampah",
      "Pengurangan Sampah (%)",
      "persen_pengurangan",
      "persentase_pengurangan",
      "persen_pengurangan_sampah",
    ];

    const apiValue = parseNumber(
      getField(achievementData.value, fields) ??
        getField(wasteData.value, fields),
    );

    if (apiValue !== null) return apiValue;

    const total = wasteTotal.value;
    const reduction = wasteReduction.value;

    return total > 0 && reduction !== null ? (reduction / total) * 100 : 0;
  });

  // =========================
  // FORMAT TAMPILAN
  // =========================
  const wasteTotalDisplay = computed(() =>
    wasteTotal.value === null ? "—" : formatNumber(wasteTotal.value),
  );

  const wasteManagedDisplay = computed(() =>
    wasteManaged.value === null ? "—" : formatNumber(wasteManaged.value),
  );

  const wasteHandlingDisplay = computed(() =>
    wasteHandling.value === null ? "—" : formatNumber(wasteHandling.value),
  );

  const wasteReductionDisplay = computed(() =>
    wasteReduction.value === null ? "—" : formatNumber(wasteReduction.value),
  );

  const wastePercentageDisplay = computed(() =>
    wastePercentage.value === null ? "—" : formatPercent(wastePercentage.value),
  );

  const formatSmallPercentage = (value) => {
    const number = parseNumber(value);

    if (number === null || !Number.isFinite(number)) return "—";

    const decimals = Math.abs(number) > 0 && Math.abs(number) < 0.01 ? 4 : 2;

    return `${formatNumber(number, decimals)}%`;
  };

  const wasteHandlingPercentageDisplay = computed(() =>
    formatSmallPercentage(wasteHandlingPercentage.value),
  );

  const wasteReductionPercentageDisplay = computed(() =>
    formatSmallPercentage(wasteReductionPercentage.value),
  );

  // =========================
  // KOMPOSISI SAMPAH
  // =========================
  const compositionItems = computed(() => {
    const rows = compositionRows.value;

    if (!rows.length) return [];

    return rows.map((item) => {
      const label = item.indikator || item.parameter || "Lainnya";
      const rawValue =
        item.nilai ??
        getField(getRawCompositionData(item), [
          "nilai",
          "persentase",
          "persen",
          "value",
        ]);

      const number = parseNumber(rawValue);

      return {
        label,
        value: rawValue,
        number,
        display: number === null ? "—" : formatPercent(number),
      };
    });
  });

  function getRawCompositionData(item) {
    if (item.raw_data && typeof item.raw_data === "object") {
      return item.raw_data;
    }

    return {};
  }

  return {
    wasteTotal,
    wasteManaged,
    wasteHandling,
    wasteReduction,
    wastePercentage,
    wasteTotalDisplay,
    wasteManagedDisplay,
    wasteHandlingDisplay,
    wasteReductionDisplay,
    wastePercentageDisplay,
    wasteHandlingPercentage,
    wasteReductionPercentage,
    wasteHandlingPercentageDisplay,
    wasteReductionPercentageDisplay,
    compositionItems,
  };
}

export function useEnvironmentalRiskStatistics({
  ikuValue,
  ikaValue,
  wastePercentage,
  parseNumber,
  formatNumber,
}) {
  const environmentalRisk = computed(() => {
    const iku = parseNumber(ikuValue.value);
    const ika = parseNumber(ikaValue.value);
    const waste = parseNumber(wastePercentage.value);

    if (iku === null || ika === null || waste === null) {
      return null;
    }

    const ikuNormalized = Math.min(Math.max(iku, 0), 100);
    const ikaNormalized = Math.min(Math.max(ika, 0), 100);
    const wasteNormalized = Math.min(Math.max(waste, 0), 100);

    const environmentalScore =
      (ikuNormalized + ikaNormalized + wasteNormalized) / 3;

    const risk = 100 - environmentalScore;

    return Math.min(Math.max(risk, 0), 100);
  });

  const environmentalRiskDisplay = computed(() => {
    if (environmentalRisk.value === null) {
      return "—";
    }

    return `${formatNumber(environmentalRisk.value, 2)}%`;
  });

  return {
    environmentalRisk,
    environmentalRiskDisplay,
  };
}

export function useFloodRiskStatistics({
  floodRiskData,
  parseNumber,
  formatNumber,
}) {
  const floodRiskValue = computed(() => {
    const item = floodRiskData.value;

    if (!item) {
      return null;
    }

    const candidates = [
      item.value,
      item.pixelValue,
      item.result?.value,
      item.result?.pixelValue,
      item.results?.[0]?.value,
      item.results?.[0]?.pixelValue,
      item.pixelValues?.[0],
      item.values?.[0],
    ];

    for (const candidate of candidates) {
      const number = parseNumber(candidate);

      if (number !== null) {
        return number;
      }
    }

    return null;
  });

  const floodRiskCategory = computed(() => {
    const value = floodRiskValue.value;

    if (value === null) {
      return null;
    }

    if (value <= 0.333) {
      return "RENDAH";
    }

    if (value <= 0.666) {
      return "SEDANG";
    }

    return "TINGGI";
  });

  const floodRiskDisplay = computed(() => {
    if (floodRiskValue.value === null) {
      return "—";
    }

    return `${formatNumber(floodRiskValue.value * 100, 2)}%`;
  });

  const floodRiskProgress = computed(() => {
    if (floodRiskValue.value === null) {
      return 0;
    }

    return Math.min(Math.max(floodRiskValue.value * 100, 0), 100);
  });

  return {
    floodRiskValue,
    floodRiskCategory,
    floodRiskDisplay,
    floodRiskProgress,
  };
}

export function useParameterCount({
  ikuRows,
  ikaRows,
  floodRiskValue,
  wasteData,
  achievementData,
  managedData,
  compositionData,
}) {
  const parameterCount = computed(() => {
    let count = 0;

    if (ikuRows.value.length) count++;
    if (ikaRows.value.length) count++;
    if (floodRiskValue.value !== null) count++;

    if (
      wasteData.value ||
      achievementData.value ||
      managedData.value ||
      compositionData.value
    ) {
      count++;
    }

    return count;
  });

  return {
    parameterCount,
  };
}