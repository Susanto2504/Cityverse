import { computed } from "vue";

export function useJalanStats(listJalan) {
  const stats = computed(() => {
    const totalRuas = listJalan.value.length;

    const totalPanjangM = listJalan.value.reduce(
      (acc, curr) => acc + Number(curr.panjang_m || 0),
      0,
    );

    const allSegments = listJalan.value.flatMap((jalan) =>
      Array.isArray(jalan.segmen_jalans) ? jalan.segmen_jalans : [],
    );

    const lancar = allSegments.filter(
      (segmen) => segmen.tingkat_kepadatan === "Lancar",
    ).length;

    const sedang = allSegments.filter(
      (segmen) => segmen.tingkat_kepadatan === "Sedang",
    ).length;

    const macet = allSegments.filter(
      (segmen) => segmen.tingkat_kepadatan === "Macet",
    ).length;

    return {
      totalRuas,
      totalPanjangKm: (totalPanjangM / 1000).toFixed(2),
      lancar,
      sedang,
      macet,
    };
  });

  return {
    stats,
  };
}
