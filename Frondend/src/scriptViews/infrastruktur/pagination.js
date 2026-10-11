import { computed, watch } from "vue";

export function useInfrastructurePagination({
  infrastructureData,
  search,
  activeCategory,
  currentPage,
  perPage,
}) {
  // Filter berdasarkan kategori dan pencarian
  const filteredData = computed(() => {
    let data = infrastructureData.value;

    if (activeCategory.value !== "Semua Aset") {
      data = data.filter((item) => item.jenis === activeCategory.value);
    }

    const keyword = search.value.trim().toLowerCase();

    if (keyword) {
      data = data.filter((item) =>
        [
          item.nama,
          item.kode,
          item.jenis,
          item.lokasi,
          item.tahun,
          item.judul,
          item.kondisi,
          item.satuan,
        ].some((value) =>
          String(value ?? "")
            .toLowerCase()
            .includes(keyword),
        ),
      );
    }

    return data;
  });

  // Menghitung jumlah halaman
  const totalPages = computed(() =>
    Math.ceil(filteredData.value.length / perPage.value),
  );

  // Data yang ditampilkan pada halaman aktif
  const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;

    return filteredData.value.slice(start, start + perPage.value);
  });

  // Nomor halaman dengan ellipsis
  const visiblePages = computed(() => {
    const total = totalPages.value;
    const current = currentPage.value;

    if (total <= 5) {
      return Array.from({ length: total }, (_, i) => i + 1);
    }

    if (current <= 3) {
      return [1, 2, 3, 4, "...", total];
    }

    if (current >= total - 2) {
      return [1, "...", total - 3, total - 2, total - 1, total];
    }

    return [1, "...", current - 1, current, current + 1, "...", total];
  });

  // Kembali ke halaman pertama ketika pencarian atau kategori berubah
  watch([search, activeCategory], () => {
    currentPage.value = 1;
  });

  // Menjaga halaman aktif agar tetap valid
  watch(totalPages, (total) => {
    if (total === 0) {
      currentPage.value = 1;
    } else if (currentPage.value > total) {
      currentPage.value = total;
    }
  });

  // Navigasi halaman
  const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
      currentPage.value = page;
    }
  };

  const previousPage = () => {
    if (currentPage.value > 1) {
      currentPage.value--;
    }
  };

  const nextPage = () => {
    if (currentPage.value < totalPages.value) {
      currentPage.value++;
    }
  };

  return {
    filteredData,
    totalPages,
    paginatedData,
    visiblePages,
    goToPage,
    previousPage,
    nextPage,
  };
}
