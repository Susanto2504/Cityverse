import { computed, onMounted, ref } from "vue";
import { useInfrastructurePagination } from "./pagination.js";
import { useInfrastructureStatistics } from "./statistics.js";

const API_INFRASTRUKTUR = `${import.meta.env.VITE_API_URL}/api/infrastruktur`;

// State bersama untuk seluruh halaman
const infrastructureData = ref([]);
const loading = ref(false);
const errorMessage = ref("");

let hasLoaded = false;
let infrastructureRequest = null;

// Kategori infrastruktur
const categories = [
  "Semua Aset",
  "Jembatan",
  "Drainase",
  "Pengelolaan Kota",
  "Rumah",
];

// Mengambil data API satu kali dan menggunakan hasilnya bersama
function loadInfrastructureData() {
  // Gunakan data yang sudah berhasil dimuat
  if (hasLoaded) {
    return Promise.resolve(infrastructureData.value);
  }

  // Gunakan request yang sedang berjalan jika ada
  if (infrastructureRequest) {
    return infrastructureRequest;
  }

  loading.value = true;
  errorMessage.value = "";

  infrastructureRequest = (async () => {
    try {
      const response = await fetch(API_INFRASTRUKTUR, {
        method: "GET",
        headers: {
          Accept: "application/json",
        },
      });

      if (!response.ok) {
        throw new Error(
          `Gagal mengambil data infrastruktur. Status: ${response.status}`,
        );
      }

      const result = await response.json();

      if (!result.success || !Array.isArray(result.data)) {
        throw new Error("Format respons API infrastruktur tidak valid.");
      }

      infrastructureData.value = result.data.map((item) => ({
        id: item.id,
        api_id: item.api_id,
        kode: item.kode,
        jenis: item.jenis,
        nama: item.nama,
        judul: item.judul,
        lokasi: item.lokasi,
        tahun: item.tahun,
        nilai:
          item.nilai === null || item.nilai === undefined || item.nilai === ""
            ? null
            : Number(item.nilai),
        satuan: item.satuan,
        kondisi: item.kondisi,
        sumber: item.sumber,
      }));

      hasLoaded = true;

      return infrastructureData.value;
    } catch (error) {
      console.error("Gagal memuat data infrastruktur:", error);

      errorMessage.value =
        error.message || "Terjadi kesalahan saat memuat data infrastruktur.";

      infrastructureData.value = [];

      return [];
    } finally {
      loading.value = false;
      infrastructureRequest = null;
    }
  })();

  return infrastructureRequest;
}

// Composable utama untuk seluruh halaman
export function useInfrastruktur({ autoLoad = true } = {}) {
  // State pencarian dan pagination tetap khusus pemanggil
  const search = ref("");
  const activeCategory = ref("Semua Aset");
  const currentPage = ref(1);
  const perPage = ref(10);

  // Statistik menggunakan data bersama
  const { categoryCounts, totalData, conditionCounts } =
    useInfrastructureStatistics(infrastructureData);

  // Persentase aset dalam kondisi baik
  const percentageGood = computed(() => {
    if (totalData.value === 0) {
      return 0;
    }

    return Math.round((conditionCounts.value.Baik / totalData.value) * 100);
  });

  // Pagination menggunakan data bersama
  const {
    filteredData,
    totalPages,
    paginatedData,
    visiblePages,
    goToPage,
    previousPage,
    nextPage,
  } = useInfrastructurePagination({
    infrastructureData,
    search,
    activeCategory,
    currentPage,
    perPage,
  });

  // Muat data hanya jika diminta
  onMounted(() => {
    if (autoLoad) {
      loadInfrastructureData();
    }
  });

  return {
    search,
    activeCategory,
    currentPage,
    perPage,

    loading,
    errorMessage,
    infrastructureData,

    categories,
    loadInfrastructureData,

    filteredData,
    categoryCounts,
    totalData,
    conditionCounts,
    percentageGood,

    totalPages,
    paginatedData,
    visiblePages,
    goToPage,
    previousPage,
    nextPage,
  };
}
