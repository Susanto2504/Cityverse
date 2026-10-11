import { ref, computed, onMounted, onUnmounted, nextTick, watch } from "vue";
import L from "leaflet";
import "leaflet/dist/leaflet.css";
import { useJalanStore } from "./store";
import { useJalanStats } from "./stats";
import { normalizeGeometry, getRoadSegments, getRoadGeometry, getTotalCapacity, getTotalVolume, getTrafficSummary } from "./roadData";
import { createConditionMarker, toggleConditionDetails, isConditionExpanded, getConditionSegments, } from "./condition";

import markerIcon2x from "leaflet/dist/images/marker-icon-2x.png";
import markerIcon from "leaflet/dist/images/marker-icon.png";
import markerShadow from "leaflet/dist/images/marker-shadow.png";

delete L.Icon.Default.prototype._getIconUrl;

L.Icon.Default.mergeOptions({
  iconUrl: markerIcon,
  iconRetinaUrl: markerIcon2x,
  shadowUrl: markerShadow,
});

const API_URL = import.meta.env.VITE_API_URL;

export function useJalan() {
  const {
    listJalan,
    loadJalan,
    refreshJalan,
    getJalanById,
  } = useJalanStore();

  const searchQuery = ref("");
  const loading = ref(false);
  const syncing = ref(false);

  const currentPage = ref(1);
  const perPage = 10;

  const { stats } = useJalanStats(listJalan);

  const filteredList = computed(() => {
    const keyword = searchQuery.value.toLowerCase().trim();

    if (!keyword) {
      return listJalan.value;
    }

    return listJalan.value.filter((jalan) => {
      const nama = String(jalan.nama_ruas_jalan || "").toLowerCase();
      const id = String(jalan.id_jalan || "").toLowerCase();

      return nama.includes(keyword) || id.includes(keyword);
    });
  });

  const totalPages = computed(() => {
    return Math.max(1, Math.ceil(filteredList.value.length / perPage));
  });

  const paginatedList = computed(() => {
    const start = (currentPage.value - 1) * perPage;
    const end = start + perPage;

    return filteredList.value.slice(start, end);
  });

  const paginationStart = computed(() => {
    if (!filteredList.value.length) {
      return 0;
    }

    return (currentPage.value - 1) * perPage + 1;
  });

  const paginationEnd = computed(() => {
    return Math.min(currentPage.value * perPage, filteredList.value.length);
  });

  const resetPagination = () => {
    currentPage.value = 1;
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

  let map = null;
  let polylineGroup = null;
  let conditionMarkerGroup = null;
  let mapRenderer = null;

  const initMap = () => {
    map = L.map("map", {
      zoomControl: true,
    }).setView([-5.14, 119.4], 13);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      maxZoom: 19,
      attribution: "&copy; OpenStreetMap",
    }).addTo(map);

    polylineGroup = L.featureGroup().addTo(map);
    conditionMarkerGroup = L.featureGroup().addTo(map);

    mapRenderer = L.canvas({
      padding: 0.5,
    });
  };

  const getRoadColor = (segmen) => {
    const kondisi = String(segmen?.kondisi_jalan || "")
      .trim()
      .toLowerCase();

    // Kondisi BANJIR
    if (kondisi === "banjir") {
      return "#2563eb";
    }

    // Kondisi LONGSOR
    if (kondisi === "longsor") {
      return "#92400e";
    }

    // Kondisi NORMAL / LAINNYA
    // Mengikuti tingkat kepadatan jalan
    if (segmen?.tingkat_kepadatan === "Lancar") {
      return "#10b981";
    }

    if (segmen?.tingkat_kepadatan === "Sedang") {
      return "#f59e0b";
    }

    if (segmen?.tingkat_kepadatan === "Macet") {
      return "#ef4444";
    }

    return "#64748b";
  };

  const renderGeometriesOnMap = () => {
    if (!polylineGroup || !conditionMarkerGroup || !mapRenderer) {
      return;
    }

    polylineGroup.clearLayers();
    conditionMarkerGroup.clearLayers();

    for (const jalan of listJalan.value) {
      const segments = getRoadSegments(jalan);

      for (const segmen of segments) {
        const coords = normalizeGeometry(segmen);

        if (coords.length < 2) {
          continue;
        }

        const polyline = L.polyline(coords, {
          renderer: mapRenderer,

          // WARNA DITENTUKAN DARI KONDISI JALAN
          color: getRoadColor(segmen),

          weight: 5,
          opacity: 0.9,
          lineCap: "round",
          lineJoin: "round",
        });

        const kapasitas =
          segmen.kapasitas_jalan != null
            ? Number(segmen.kapasitas_jalan).toLocaleString()
            : "-";

        const volume =
          segmen.volume_kendaraan != null
            ? Number(segmen.volume_kendaraan).toLocaleString()
            : "-";
            
        const kondisiJalan = segmen.kondisi_jalan || "Normal";

        let warnaKondisi = "#64748b";

        if (kondisiJalan === "Banjir") {
          warnaKondisi = "#2563eb";
        } else if (kondisiJalan === "Longsor") {
          warnaKondisi = "#92400e";
        } else if (kondisiJalan === "Lainnya") {
          warnaKondisi = "#64748b";
        } else if (kondisiJalan === "Normal") {
          warnaKondisi = "#10b981";
        }

        polyline.bindPopup(`
                    <div style="min-width:240px">
                        <strong>
                            ${jalan.nama_ruas_jalan ?? "Tidak bernama"}
                        </strong>

                        <br>

                        <span style="color:#64748b">
                            Segmen OSM:
                            ${segmen.osm_id ?? "-"}
                        </span>

                        <br><br>

                        Panjang:
                        ${Number(segmen.panjang_m || 0).toFixed(2)}
                        m

                        <br>

                        Tipe:
                        ${segmen.tipe_jalan_detail ?? "-"}

                        <br>

                        Kapasitas:
                        ${kapasitas}
                        smp/jam

                        <br>

                        Volume:
                        ${volume}
                        kend/jam

                        <br>

                        Kepadatan:
                        ${segmen.tingkat_kepadatan ?? "-"}

                        <br>

                        Kondisi Jalan:
                        <strong style="color:${warnaKondisi}">
                            ${kondisiJalan}
                        </strong>

                        ${
                          kondisiJalan === "Lainnya" && segmen.kondisi_lainnya
                            ? `
                                    <br>
                                    Keterangan:
                                    ${segmen.kondisi_lainnya}
                                `
                            : ""
                        }

                        ${
                          segmen.panjang_kondisi_m != null
                            ? `
                                    <br>
                                    Panjang Kondisi:
                                    ${Number(segmen.panjang_kondisi_m).toFixed(
                                      2,
                                    )}
                                    m
                                `
                            : ""
                        }
                    </div>
                `);

        polylineGroup.addLayer(polyline);

        const conditionMarker = createConditionMarker(
          segmen,
          coords,
          jalan.nama_ruas_jalan,
          L,
        );

        if (conditionMarker) {
          conditionMarkerGroup.addLayer(conditionMarker);
        }
      }
    }
  };

  const getDataJalan = async () => {
    try {
      loading.value = true;

      await loadJalan();
      currentPage.value = 1;

      await nextTick();

      renderGeometriesOnMap();
    } catch (error) {
      console.error("Gagal mengambil data jalan:", error);

      listJalan.value = [];

      alert(`Gagal mengambil data jalan.\n\n${error.message}`);
    } finally {
      loading.value = false;
    }
  };

  const fetchDataJalan = async () => {
    try {
      syncing.value = true;

      const response = await fetch(`${API_URL}/api/jalan/sync-osm`, {
        method: "POST",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json",
        },
      });

      const result = await response.json();

      if (!response.ok || !result.success) {
        throw new Error(result.message || "Gagal melakukan sinkronisasi OSM");
      }

      console.log("Hasil sinkronisasi:", result);

      await refreshJalan();

      alert(
        `Sinkronisasi berhasil!\n\n` +
          `Ruas jalan: ${result.jumlah_ruas ?? 0}\n` +
          `Segmen jalan: ${result.jumlah_segmen ?? 0}\n` +
          `Data dilewati: ${result.jumlah_dilewati ?? 0}`,
      );
    } catch (error) {
      console.error("Gagal sinkronisasi OSM:", error);

      alert(`Gagal sinkronisasi data OSM.\n\n${error.message}`);
    } finally {
      syncing.value = false;
    }
  };

  const focusToMap = (coords) => {
    if (!map || !Array.isArray(coords) || coords.length < 2) {
      return;
    }

    map.flyToBounds(coords, {
      maxZoom: 17,
      duration: 1.5,
      padding: [40, 40],
    });
  };

  watch(searchQuery, () => {
    resetPagination();
  });

  onMounted(async () => {
    await nextTick();
    initMap();
    await getDataJalan();

    if (map) {
      setTimeout(() => {
        map.invalidateSize();
      }, 300);
    }
  });

  onUnmounted(() => {
    if (map) {
      map.remove();
      map = null;
    }

    polylineGroup = null;
    mapRenderer = null;
    conditionMarkerGroup = null;
  });

  return {
    searchQuery,
    loading,
    syncing,
    listJalan,

    currentPage,
    perPage,
    totalPages,
    paginationStart,
    paginationEnd,

    stats,
    filteredList,
    paginatedList,

    resetPagination,
    previousPage,
    nextPage,

    initMap,
    getRoadColor,
    normalizeGeometry,
    getRoadSegments,
    getRoadGeometry,
    getTotalCapacity,
    getTotalVolume,
    getTrafficSummary,
    renderGeometriesOnMap,
    focusToMap,

    getDataJalan,
    fetchDataJalan,

    loadJalan,
    refreshJalan,
    getJalanById,

    toggleConditionDetails,
    isConditionExpanded,
    getConditionSegments,
  };
  
}

