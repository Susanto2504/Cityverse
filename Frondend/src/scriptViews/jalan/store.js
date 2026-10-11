import { ref } from "vue";

const API_URL = `${import.meta.env.VITE_API_URL}/api`;

const listJalan = ref([]);
const loading = ref(false);
const error = ref(null);
const loaded = ref(false);

let loadingPromise = null;

export function useJalanStore() {
  const loadJalan = async () => {
    // Kalau data sudah pernah dimuat, langsung gunakan data yang ada
    if (loaded.value) {
      return listJalan.value;
    }

    // Kalau sedang ada request berjalan, gunakan request yang sama
    if (loadingPromise) {
      return loadingPromise;
    }

    loading.value = true;
    error.value = null;

    loadingPromise = fetch(`${API_URL}/jalan`, {
      method: "GET",
      headers: {
        Accept: "application/json",
      },
    })
      .then(async (response) => {
        if (!response.ok) {
          throw new Error(`HTTP Error ${response.status}`);
        }

        const result = await response.json();

        if (result.success === false) {
          throw new Error(result.message || "Gagal mengambil data jalan");
        }

        const rows = Array.isArray(result.data)
          ? result.data
          : Array.isArray(result)
            ? result
            : [];

        listJalan.value = rows;
        loaded.value = true;

        console.log(
          "[JALAN] Data berhasil dimuat:",
          listJalan.value.length,
          "ruas",
        );

        return listJalan.value;
      })
      .catch((err) => {
        console.error("[JALAN] Gagal mengambil data:", err);

        error.value = err.message;
        listJalan.value = [];

        throw err;
      })
      .finally(() => {
        loading.value = false;
        loadingPromise = null;
      });

    return loadingPromise;
  };

  // Dipakai kalau memang data jalan berubah
  const refreshJalan = async () => {
    loaded.value = false;
    return loadJalan();
  };

  // Cari jalan berdasarkan ID
  const getJalanById = (id) => {
    return (
      listJalan.value.find((jalan) => String(jalan.id_jalan) === String(id)) ||
      null
    );
  };

  return {
    listJalan,
    loading,
    error,
    loaded,
    loadJalan,
    refreshJalan,
    getJalanById,
  };
}
