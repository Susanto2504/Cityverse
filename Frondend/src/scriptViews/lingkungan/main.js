import { computed, onMounted, ref } from "vue";
import { normalizeText, normalizeKey, parseNumber, formatNumber, formatPercent, getField, getRawData, getSourceName} from "./utils.js";
import { useEnvironmentalStatistics, useWasteStatistics, useEnvironmentalRiskStatistics, useFloodRiskStatistics, useParameterCount, } from "./statistics.js";
import { useMonitoringData } from "./monitoring.js";

let lingkunganInstance = null;
let environmentalRequest = null;
let environmentalDataLoaded = false;


const ENVIRONMENT_API = `${import.meta.env.VITE_API_URL}/api/lingkungan`;

export function useLingkungan() {
  if (lingkunganInstance) {
    return lingkunganInstance;
  }

  const loading = ref(false);
  const errorMessage = ref("");

  const search = ref("");
  const activeFilter = ref("Semua Parameter");

  const environmentRows = ref([]);
  const ikuData = ref(null);
  const ikaData = ref(null);

  const wasteData = ref(null);
  const achievementData = ref(null);
  const managedData = ref(null);
  const compositionData = ref(null);

  const ikuRows = ref([]);
  const ikaRows = ref([]);
  const wasteRows = ref([]);
  const achievementRows = ref([]);
  const managedRows = ref([]);
  const compositionRows = ref([]);

  const floodRiskData = ref(null);
  const floodRiskRow = ref(null);
  const floodRiskLoading = ref(false);
  const floodRiskError = ref("");

  const filters = [
    "Semua Parameter",
    "Kualitas Udara",
    "Kualitas Air",
    "Persampahan",
    "Risiko Banjir",
  ];

  // =========================================================
  // RESET DATA
  // =========================================================

  function resetData() {
    environmentRows.value = [];
    ikuData.value = null;
    ikaData.value = null;

    wasteData.value = null;
    achievementData.value = null;
    managedData.value = null;
    compositionData.value = null;

    ikuRows.value = [];
    ikaRows.value = [];
    wasteRows.value = [];
    achievementRows.value = [];
    managedRows.value = [];
    compositionRows.value = [];

    floodRiskData.value = null;
    floodRiskRow.value = null;
    floodRiskError.value = "";
  }

  // =========================================================
  // LOAD DATA FROM LARAVEL
  // =========================================================

  async function performLoadEnvironmentalData(){
    loading.value = true;
    floodRiskLoading.value = true;
    errorMessage.value = "";
    floodRiskError.value = "";

    resetData();

    try {
      const response = await fetch(ENVIRONMENT_API, {
        method: "GET",
        headers: {
          Accept: "application/json",
        },
      });

      if (!response.ok) {
        throw new Error(
          `HTTP ${response.status} saat mengambil data lingkungan dari Laravel.`,
        );
      }

      const result = await response.json();

      if (!result?.success) {
        throw new Error(
          result?.message || "Laravel tidak mengembalikan data lingkungan.",
        );
      }

      const rows = Array.isArray(result.data) ? result.data : [];
      environmentRows.value = rows;

      console.log("[Laravel] Data lingkungan:", result);
      console.log("[Laravel] Total data:", rows.length);

      // =====================================================
      // IKU / KUALITAS UDARA
      // =====================================================

      const ikuItem = rows.find(
        (item) =>
          normalizeText(item.parameter) === "iku" ||
          normalizeText(item.indikator).includes("indeks kualitas udara"),
      );

      if (ikuItem) {
        ikuRows.value = [ikuItem];
        ikuData.value = getRawData(ikuItem);
      }

      // =====================================================
      // IKA / KUALITAS AIR
      // =====================================================

      const ikaItem = rows.find(
        (item) =>
          normalizeText(item.parameter) === "ika" ||
          normalizeText(item.parameter) === "kualitas air" ||
          normalizeText(item.indikator).includes("indeks kualitas air"),
      );

      if (ikaItem) {
        ikaRows.value = [ikaItem];

        ikaData.value = getRawData(ikaItem) || {
          "Kode Wilayah": ikaItem.kode_wilayah,
          kabkota: ikaItem.wilayah,
          tahun: ikaItem.tahun,
          IKA: ikaItem.nilai,
        };
      }

      // =====================================================
      // PERSAMPAHAN - DATA UTAMA
      // =====================================================

      const wasteItem = rows.find(
        (item) => normalizeText(item.indikator) === "data persampahan",
      );

      if (wasteItem) {
        wasteRows.value = [wasteItem];
        wasteData.value = getRawData(wasteItem);
      }

      // =====================================================
      // PERSAMPAHAN - CAPAIAN
      // =====================================================

      const achievementItem = rows.find(
        (item) => normalizeText(item.indikator) === "capaian persampahan",
      );

      if (achievementItem) {
        achievementRows.value = [achievementItem];
        achievementData.value = getRawData(achievementItem);
      }

      // =====================================================
      // PERSAMPAHAN - TERKELOLA
      // =====================================================

      const managedItem = rows.find(
        (item) =>
          normalizeText(item.indikator) === "persentase sampah terkelola",
      );

      if (managedItem) {
        managedRows.value = [managedItem];
        managedData.value = getRawData(managedItem);
      }

      // =====================================================
      // KOMPOSISI SAMPAH
      // =====================================================

      const compositionItemsFromDatabase = rows.filter(
        (item) =>
          normalizeText(item.parameter) === "persampahan" &&
          [
            "sisa makanan",
            "plastik",
            "kertas/karton",
            "kayu/ranting",
            "karet/kulit",
            "kain",
            "logam",
            "kaca",
            "lainnya",
            "timbulan sampah",
          ].includes(normalizeText(item.indikator)),
      );

      if (compositionItemsFromDatabase.length) {
        compositionRows.value = compositionItemsFromDatabase;

        compositionData.value = getRawData(compositionItemsFromDatabase[0]);
      }

      // =====================================================
      // RISIKO BANJIR
      // =====================================================

      const floodItem = rows.find(
        (item) =>
          normalizeText(item.parameter) === "risiko banjir" ||
          normalizeText(item.indikator) === "indeks risiko banjir",
      );

      if (floodItem) {
        floodRiskRow.value = floodItem;

        floodRiskData.value = getRawData(floodItem)?.response_bnpb ||
          getRawData(floodItem) || {
            value: floodItem.nilai,
          };
      } else {
        floodRiskError.value = "Data risiko banjir belum tersedia di database.";
      }

      console.log("[Laravel] IKU:", ikuItem);
      console.log("[Laravel] IKA:", ikaItem);
      console.log("[Laravel] Persampahan:", wasteItem);
      console.log("[Laravel] Capaian:", achievementItem);
      console.log("[Laravel] Terkelola:", managedItem);
      console.log("[Laravel] Komposisi:", compositionItemsFromDatabase);
      console.log("[Laravel] Risiko Banjir:", floodItem);
    } catch (error) {
      console.error("[Laravel] Gagal mengambil data lingkungan:", error);

      errorMessage.value =
        error?.message ||
        "Terjadi kesalahan ketika mengambil data lingkungan dari Laravel.";

      floodRiskError.value = errorMessage.value;
    } finally {
      loading.value = false;
      floodRiskLoading.value = false;
    }
  }

  
async function loadEnvironmentalData(force = false) {
  // Jika request sedang berjalan, gunakan request yang sama.
  if (environmentalRequest) {
    return environmentalRequest;
  }

  // Jika data sudah berhasil dimuat, tidak perlu request ulang.
  if (environmentalDataLoaded && !force) {
    return;
  }

  // Simpan promise agar pemanggilan bersamaan tidak membuat request baru.
  environmentalRequest = performLoadEnvironmentalData();

  try {
    await environmentalRequest;

    // Tandai berhasil hanya jika tidak ada error.
    if (!errorMessage.value) {
      environmentalDataLoaded = true;
    }
  } finally {
    environmentalRequest = null;
  }
}


  // =========================================================
  // IKU
  // =========================================================

  const { ikuValue, ikuDisplay, ikaValue, ikaDisplay } =
    useEnvironmentalStatistics({
      ikuData,
    ikuRows,
    ikaData,
    ikaRows,
    parseNumber,
    formatNumber,
    getField,
    });

    const {
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
    } = useWasteStatistics({
      wasteData,
      achievementData,
      managedData,
      compositionRows,
      parseNumber,
      formatNumber,
      formatPercent,
      getField,
    });

  const {
    floodRiskValue,
    floodRiskCategory,
    floodRiskDisplay,
    floodRiskProgress,
  } = useFloodRiskStatistics({
    floodRiskData,
    parseNumber,
    formatNumber,
  });

  // =========================================================
  // MONITORING DATA
  // =========================================================
  const { monitoringData, filteredData } = useMonitoringData({
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
  });

  // =========================================================
  // PARAMETER COUNT
  // =========================================================

  const { parameterCount } = useParameterCount({
    ikuRows,
    ikaRows,
    floodRiskValue,
    wasteData,
    achievementData,
    managedData,
    compositionData,
  });

  // =========================================================
  // ENVIRONMENTAL RISK
  // =========================================================

  const {
    environmentalRisk,
    environmentalRiskDisplay,
  } = useEnvironmentalRiskStatistics({
    ikuValue,
    ikaValue,
    wastePercentage,
    parseNumber,
    formatNumber,
  });

  // =========================================================
  // STATUS
  // =========================================================

  const ikuStatus = computed(() =>
    ikuValue.value !== null ? "TERSEDIA" : "BELUM ADA",
  );

  const ikaStatus = computed(() =>
    ikaValue.value !== null ? "TERSEDIA" : "BELUM ADA",
  );

  const floodRiskStatus = computed(() => {
    if (floodRiskLoading.value) {
      return "MENGAMBIL DATA";
    }

    return floodRiskValue.value !== null
      ? `TERSEDIA · ${floodRiskCategory.value}`
      : "BELUM ADA";
  });

  const wasteStatus = computed(() =>
    wasteData.value || achievementData.value || managedData.value
      ? "DATA DATABASE"
      : "BELUM ADA",
  );

  // =========================================================
  // REFRESH
  // =========================================================

  async function refreshData() {
    await loadEnvironmentalData(true);
  }

  // =========================================================
  // INITIAL LOAD
  // =========================================================

  onMounted(() => {
    loadEnvironmentalData();
  });

  // =========================================================
  // RETURN
  // =========================================================

  lingkunganInstance = {
    // State
    loading,
    errorMessage,
    search,
    activeFilter,
    filters,

    // API data
    environmentRows,
    ikuData,
    ikaData,
    wasteData,
    achievementData,
    managedData,
    compositionData,

    ikuRows,
    ikaRows,
    wasteRows,
    achievementRows,
    managedRows,
    compositionRows,

    floodRiskData,
    floodRiskRow,
    floodRiskLoading,
    floodRiskError,

    // IKU
    ikuValue,
    ikuDisplay,
    ikuStatus,

    // IKA
    ikaValue,
    ikaDisplay,
    ikaStatus,

    // Persampahan
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
    wasteStatus,

    // Risiko banjir
    floodRiskValue,
    floodRiskCategory,
    floodRiskDisplay,
    floodRiskProgress,
    floodRiskStatus,

    // Monitoring
    monitoringData,
    filteredData,
    parameterCount,

    // Risiko lingkungan
    environmentalRisk,
    environmentalRiskDisplay,

    // Functions
    loadEnvironmentalData,
    refreshData,
    resetData,

    // Utilities jika nanti diperlukan di template
    normalizeText,
    normalizeKey,
    parseNumber,
    formatNumber,
    formatPercent,
    getField,
    getRawData,
    getSourceName,
  };

  return lingkunganInstance;
}