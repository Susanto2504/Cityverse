import { ref, computed, onMounted, onUnmounted } from "vue";

const WILAYAH_API = `${import.meta.env.VITE_API_URL}/api/wilayah`;
const CUACA_API = `${import.meta.env.VITE_API_URL}/api/cuaca`;

export function useCuaca() {
  // =========================================================
  // STATE
  // =========================================================

  const loading = ref(true);
  const error = ref(null);

  const makassarList = ref([]);
  const currentWeather = ref(null);
  const hourlyForecast = ref([]);

  const searchQuery = ref("");
  const selectedAdm4 = ref("");

  // Jam realtime WITA
  const currentTime = ref("");
  let timer = null;

  // =========================================================
  // JAM REALTIME WITA
  // =========================================================

  const updateMakassarTime = () => {
    const now = new Date();

    currentTime.value = now
      .toLocaleTimeString("id-ID", {
        timeZone: "Asia/Makassar",
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: false,
      })
      .replace(/\./g, ":");
  };

  // =========================================================
  // FETCH DAFTAR WILAYAH
  // =========================================================

  const fetchWilayahList = async () => {
    try {
      const res = await fetch(WILAYAH_API, {
        headers: {
          Accept: "application/json",
        },
      });

      if (!res.ok) {
        throw new Error(`HTTP ${res.status} saat mengambil daftar wilayah.`);
      }

      const json = await res.json();

      // Mendukung:
      // 1. response langsung array
      // 2. Laravel Resource { data: [...] }
      // 3. Pagination { data: { data: [...] } }
      const rawData = json.data?.data || json.data || json;

      if (Array.isArray(rawData) && rawData.length > 0) {
        makassarList.value = rawData.map((item) => {
          const codeVal =
            item.kode_wilayah || item.kode || item.code || item.adm4 || item.id;

          const nameVal =
            item.nama_wilayah ||
            item.nama_kelurahan ||
            item.kelurahan ||
            item.nama ||
            item.name ||
            "Tanpa Nama";

          const kecVal = item.nama_kecamatan || item.kecamatan || "";

          return {
            code: String(codeVal),
            name: String(nameVal),
            kecamatan: kecVal ? String(kecVal) : "",
          };
        });

        // Jika selectedAdm4 belum terisi
        // atau tidak tersedia di daftar
        if (makassarList.value.length > 0) {
          const exists = makassarList.value.some(
            (item) => item.code === selectedAdm4.value,
          );

          if (!selectedAdm4.value || !exists) {
            selectedAdm4.value = makassarList.value[0].code;
          }
        }
      }
    } catch (err) {
      console.error("Gagal memuat daftar wilayah:", err);

      throw err;
    }
  };

  // =========================================================
  // FILTER WILAYAH
  // =========================================================

  const filteredMakassarList = computed(() => {
    if (!searchQuery.value) {
      return makassarList.value;
    }

    const query = searchQuery.value.toLowerCase();

    return makassarList.value.filter(
      (item) =>
        (item.name && item.name.toLowerCase().includes(query)) ||
        (item.kecamatan && item.kecamatan.toLowerCase().includes(query)),
    );
  });

  // =========================================================
  // VISIBILITY / JARAK PANDANG
  // =========================================================

  const getVisibilityText = (item) => {
    if (!item) {
      return "--";
    }

    const vs = item.jarak_pandang ?? item.vs_text ?? item.vs;

    if (vs !== undefined && vs !== null && vs !== "") {
      const vsStr = String(vs);

      if (vsStr === "0") {
        return "> 10 km";
      }

      return vsStr.includes("km") ? vsStr : `${vsStr} km`;
    }

    return "--";
  };

  // =========================================================
  // FETCH DATA CUACA
  // =========================================================

  const fetchWeatherData = async () => {
    if (!selectedAdm4.value) {
      return;
    }

    loading.value = true;
    error.value = null;

    try {
      const response = await fetch(`${CUACA_API}/${selectedAdm4.value}`, {
        headers: {
          Accept: "application/json",
        },
      });

      if (!response.ok) {
        throw new Error("Gagal mengambil data dari server Laravel");
      }

      const resData = await response.json();

      const cuacaList = resData.data || resData;

      if (Array.isArray(cuacaList) && cuacaList.length > 0) {
        // Filter item yang valid
        const validItems = cuacaList.filter(
          (item) => Number(item.suhu) > 0 || item.keterangan_cuaca,
        );

        // Semua data valid untuk prakiraan jam-jaman
        hourlyForecast.value = validItems.length > 0 ? validItems : cuacaList;

        // Item pertama sebagai cuaca saat ini
        currentWeather.value =
          validItems.length > 0 ? validItems[0] : cuacaList[0];
      } else {
        throw new Error("Data cuaca tidak ditemukan untuk wilayah ini.");
      }
    } catch (err) {
      console.error("Gagal mengambil data cuaca:", err);

      error.value = err.message || "Terjadi kesalahan saat memuat data.";
    } finally {
      loading.value = false;
    }
  };

  // =========================================================
  // INITIAL DATA
  // =========================================================

  const initData = async () => {
    loading.value = true;
    error.value = null;

    try {
      await fetchWilayahList();
      await fetchWeatherData();
    } catch (err) {
      console.error("Gagal menginisialisasi data cuaca:", err);

      error.value = err?.message || "Gagal memuat data cuaca.";
    } finally {
      loading.value = false;
    }
  };

  // =========================================================
  // FORMAT TANGGAL
  // =========================================================

  const formatDateOnly = (dateStr) => {
    if (!dateStr) {
      return "-";
    }

    const datePart = dateStr.split("T")[0].split(" ")[0];

    const [year, month, day] = datePart.split("-");

    if (!year || !month || !day) {
      return dateStr;
    }

    return `${day}-${month}-${year}`;
  };

  // =========================================================
  // FORMAT JAM
  // =========================================================

  const formatTime = (dateStr) => {
    if (!dateStr) {
      return "-";
    }

    const timePart = dateStr.includes("T")
      ? dateStr.split("T")[1]
      : dateStr.split(" ")[1];

    return timePart?.substring(0, 5) || dateStr;
  };

  // =========================================================
  // REFRESH
  // =========================================================

  const refreshData = async () => {
    await initData();
  };

  // =========================================================
  // MOUNTED
  // =========================================================

  onMounted(() => {
    initData();

    updateMakassarTime();

    timer = setInterval(updateMakassarTime, 1000);
  });

  // =========================================================
  // UNMOUNTED
  // =========================================================

  onUnmounted(() => {
    if (timer) {
      clearInterval(timer);
      timer = null;
    }
  });

  // =========================================================
  // RETURN
  // =========================================================

  return {
    // State
    loading,
    error,
    makassarList,
    currentWeather,
    hourlyForecast,

    searchQuery,
    selectedAdm4,
    currentTime,

    // Computed
    filteredMakassarList,

    // Functions
    updateMakassarTime,
    fetchWilayahList,
    fetchWeatherData,
    initData,
    refreshData,

    getVisibilityText,
    formatDateOnly,
    formatTime,
  };
}
