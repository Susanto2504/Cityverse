import { computed } from "vue";

export function useInfrastructureStatistics(infrastructureData) {
  // Statistik berdasarkan kategori
  const categoryCounts = computed(() => {
    const data = infrastructureData.value;

    return {
      Jembatan: data.filter((item) => item.jenis === "Jembatan").length,

      Drainase: data.filter((item) => item.jenis === "Drainase").length,

      "Pengelolaan Kota": data.filter(
        (item) => item.jenis === "Pengelolaan Kota",
      ).length,

      Rumah: data.filter((item) => item.jenis === "Rumah").length,
    };
  });

  // Total seluruh data infrastruktur
  const totalData = computed(() => infrastructureData.value.length);

  // Statistik berdasarkan kondisi
  const conditionCounts = computed(() => {
    const data = infrastructureData.value;

    return {
      Baik: data.filter((item) => item.kondisi === "Baik").length,

      "Perlu Pemeliharaan": data.filter(
        (item) => item.kondisi === "Perlu Pemeliharaan",
      ).length,

      Rusak: data.filter((item) => item.kondisi === "Rusak").length,
    };
  });

  return {
    categoryCounts,
    totalData,
    conditionCounts,
  };
}
