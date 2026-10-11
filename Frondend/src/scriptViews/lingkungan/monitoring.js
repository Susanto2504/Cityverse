import { computed } from "vue";

export function useMonitoringData({
  ikuRows,
  ikaRows,
  ikuValue,
  ikaValue,
  wasteData,
  wasteRows,
  wasteTotal,
  wasteManaged,
  wasteHandling,
  wasteReduction,
  wastePercentage,
  floodRiskValue,
  floodRiskRow,
  floodRiskDisplay,
  floodRiskCategory,
  formatNumber,
  formatPercent,
  getSourceName,
  search,
  activeFilter,
  normalizeText,
}) {
  const monitoringData = computed(() => {
    const data = [];

    // =========================
    // IKU
    // =========================
    for (const item of ikuRows.value) {
      data.push({
        id: `iku-${item.id}`,
        wilayah: item.wilayah || "Kota Makassar",
        kode: item.kode_wilayah || "73.71",
        parameter: "Kualitas Udara",
        indikator: item.indikator || "Indeks Kualitas Udara",
        nilai: ikuValue.value !== null ? formatNumber(ikuValue.value, 2) : "—",
        tahun: item.tahun || "2025",
        sumber: getSourceName(item),
      });
    }

    // =========================
    // IKA
    // =========================
    for (const item of ikaRows.value) {
      data.push({
        id: `ika-${item.id}`,
        wilayah: item.wilayah || "Kota Makassar",
        kode: item.kode_wilayah || "73.71",
        parameter: "Kualitas Air",
        indikator: item.indikator || "Indeks Kualitas Air",
        nilai: ikaValue.value !== null ? formatNumber(ikaValue.value, 2) : "—",
        tahun: item.tahun || "2024",
        sumber: getSourceName(item),
      });
    }

    // =========================
    // PERSAMPAHAN
    // =========================
    if (wasteData.value) {
      const item = wasteRows.value[0];
      const tahun = item?.tahun || 2025;
      const wilayah = item?.wilayah || "Kota Makassar";
      const kode = item?.kode_wilayah || "73.71";

      data.push(
        {
          id: "waste-total",
          wilayah,
          kode,
          parameter: "Persampahan",
          indikator: "Timbulan Sampah",
          nilai:
            wasteTotal.value !== null
              ? `${formatNumber(wasteTotal.value)} ton/tahun`
              : "—",
          tahun,
          sumber: getSourceName(item),
        },
        {
          id: "waste-managed",
          wilayah,
          kode,
          parameter: "Persampahan",
          indikator: "Sampah Terkelola",
          nilai:
            wasteManaged.value !== null
              ? `${formatNumber(wasteManaged.value)} ton/tahun`
              : "—",
          tahun,
          sumber: getSourceName(item),
        },
        {
          id: "waste-handling",
          wilayah,
          kode,
          parameter: "Persampahan",
          indikator: "Penanganan Sampah",
          nilai:
            wasteHandling.value !== null
              ? `${formatNumber(wasteHandling.value)} ton/tahun`
              : "—",
          tahun,
          sumber: getSourceName(item),
        },
        {
          id: "waste-reduction",
          wilayah,
          kode,
          parameter: "Persampahan",
          indikator: "Pengurangan Sampah",
          nilai:
            wasteReduction.value !== null
              ? `${formatNumber(wasteReduction.value)} ton/tahun`
              : "—",
          tahun,
          sumber: getSourceName(item),
        },
        {
          id: "waste-percentage",
          wilayah,
          kode,
          parameter: "Persampahan",
          indikator: "Persentase Sampah Terkelola",
          nilai:
            wastePercentage.value !== null
              ? formatPercent(wastePercentage.value)
              : "—",
          tahun,
          sumber: getSourceName(item),
        },
      );
    }

    // =========================
    // RISIKO BANJIR
    // =========================
    if (floodRiskValue.value !== null) {
      const item = floodRiskRow.value;

      data.push({
        id: `flood-risk-${item?.id || "data"}`,
        wilayah: item?.wilayah || "Kota Makassar",
        kode: item?.kode_wilayah || "73.71",
        parameter: "Risiko Banjir",
        indikator: item?.indikator || "Indeks Risiko Banjir",
        nilai: `${floodRiskDisplay.value} (${floodRiskCategory.value})`,
        tahun: item?.tahun || "—",
        sumber: getSourceName(item),
      });
    }

    return data;
  });

  const filteredData = computed(() => {
    let data = monitoringData.value;

    if (activeFilter.value !== "Semua Parameter") {
      data = data.filter((item) => item.parameter === activeFilter.value);
    }

    const keyword = normalizeText(search.value);

    if (keyword) {
      data = data.filter((item) =>
        [
          item.wilayah,
          item.kode,
          item.parameter,
          item.indikator,
          item.nilai,
          item.tahun,
          item.sumber,
        ].some((value) => normalizeText(value).includes(keyword)),
      );
    }

    return data;
  });

  return {
    monitoringData,
    filteredData,
  };
}