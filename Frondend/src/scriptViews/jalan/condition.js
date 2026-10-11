import { getRoadSegments } from "./roadData";
import { ref } from "vue";

const expandedConditions = ref(new Set());

export function getConditionMarkerColor(kondisi) {
  const value = String(kondisi || "")
    .trim()
    .toLowerCase();

  if (value === "banjir") {
    return "#2563eb";
  }

  if (value === "longsor") {
    return "#92400e";
  }

  return "#ef4444";
}

export function createConditionMarker(segmen, coords, namaJalan, L) {
  const kondisi = String(segmen?.kondisi_jalan || "")
    .trim()
    .toLowerCase();

  if (!kondisi || kondisi === "normal" || coords.length < 2) {
    return null;
  }

  const middleIndex = Math.floor(coords.length / 2);
  const middlePoint = coords[middleIndex];

  const color = getConditionMarkerColor(kondisi);

  const markerIcon = L.divIcon({
    className: "condition-marker-wrapper",
    html: `
            <div
                style="
                    width: 22px;
                    height: 22px;
                    background: ${color};
                    border: 3px solid white;
                    border-radius: 50%;
                    box-shadow: 0 2px 6px rgba(0,0,0,0.35);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                "
            >
                <i
                    class="fa-solid fa-triangle-exclamation"
                    style="
                        color: white;
                        font-size: 10px;
                    "
                ></i>
            </div>
        `,
    iconSize: [22, 22],
    iconAnchor: [11, 11],
    popupAnchor: [0, -12],
  });

  return L.marker(middlePoint, {
    icon: markerIcon,
    zIndexOffset: 1000,
  }).bindPopup(`
        <div style="min-width:220px">
            <strong>
                ${namaJalan ?? "Tidak bernama"}
            </strong>

            <br><br>

            <span style="color:${color}; font-weight:700; text-transform:uppercase">
                ${kondisi}
            </span>

            <br><br>

            Panjang kondisi:
            ${Number(segmen.panjang_kondisi_m || 0).toFixed(2)} m

            <br>

            Segmen OSM:
            ${segmen.osm_id ?? "-"}
        </div>
    `);
}

export function toggleConditionDetails(jalanId) {
  const next = new Set(expandedConditions.value);

  if (next.has(jalanId)) {
    next.delete(jalanId);
  } else {
    next.add(jalanId);
  }

  expandedConditions.value = next;
}

export function isConditionExpanded(jalanId) {
  return expandedConditions.value.has(jalanId);
}

export function getConditionSegments(jalan) {
  return getRoadSegments(jalan).filter((segmen) => {
    const kondisi = String(segmen.kondisi_jalan || "")
      .trim()
      .toLowerCase();

    return ["banjir", "longsor", "lainnya"].includes(kondisi);
  });
}
