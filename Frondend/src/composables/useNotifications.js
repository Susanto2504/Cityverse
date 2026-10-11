import { computed, onMounted, onUnmounted, ref } from "vue";

const API_BASE = import.meta.env.VITE_API_URL;

function getCookie(name) {
  const row = document.cookie
    .split("; ")
    .find((item) => item.startsWith(`${name}=`));

  return row ? decodeURIComponent(row.substring(name.length + 1)) : null;
}

async function getCsrfToken() {
  const response = await fetch(`${API_BASE}/sanctum/csrf-cookie`, {
    method: "GET",
    credentials: "include",
    headers: {
      Accept: "application/json",
    },
  });

  if (!response.ok) {
    throw new Error(`Gagal mengambil CSRF cookie. HTTP ${response.status}`);
  }

  const token = getCookie("XSRF-TOKEN");

  if (!token) {
    throw new Error("Cookie XSRF-TOKEN tidak ditemukan.");
  }

  return token;
}

const API_NOTIFICATIONS = `${API_BASE}/api/notifications`;

const notifications = ref([]);
const loading = ref(false);
const errorMessage = ref("");

let notificationInterval = null;

async function loadNotifications() {
  loading.value = true;
  errorMessage.value = "";

  try {
    const token = localStorage.getItem("token");

    const response = await fetch(API_NOTIFICATIONS, {
      method: "GET",
      headers: {
        Accept: "application/json",
        Authorization: `Bearer ${token}`,
      },
      cache: "no-store",
    });

    if (!response.ok) {
      throw new Error(`HTTP ${response.status}`);
    }

    const result = await response.json();

    if (!result.success || !Array.isArray(result.data)) {
      throw new Error("Format data notifikasi tidak sesuai.");
    }

    notifications.value = result.data.map((item) => ({
      id: item.id,
      title: item.title,
      message: item.message,
      type: item.type || "system",
      unread: !item.is_read,
      time: formatTime(item.created_at),
      created_at: item.created_at,
    }));
  } catch (error) {
    console.error("Gagal mengambil notifikasi:", error);
    errorMessage.value = "Notifikasi gagal dimuat.";
  } finally {
    loading.value = false;
  }
}

function formatTime(dateString) {
  if (!dateString) {
    return "Baru saja";
  }

  const date = new Date(dateString);

  if (Number.isNaN(date.getTime())) {
    return "Baru saja";
  }

  const now = new Date();
  const diff = Math.floor((now - date) / 1000);

  if (diff < 60) {
    return "Baru saja";
  }

  if (diff < 3600) {
    return `${Math.floor(diff / 60)} menit yang lalu`;
  }

  if (diff < 86400) {
    return `${Math.floor(diff / 3600)} jam yang lalu`;
  }

  if (diff < 604800) {
    return `${Math.floor(diff / 86400)} hari yang lalu`;
  }

  return date.toLocaleDateString("id-ID", {
    day: "2-digit",
    month: "short",
    year: "numeric",
  });
}

const notificationCount = computed(() => {
  return notifications.value.filter((notification) => notification.unread)
    .length;
});

async function markAsRead(id) {
  try {
    const token = localStorage.getItem("token");
    const xsrfToken = await getCsrfToken();

    const response = await fetch(`${API_NOTIFICATIONS}/${id}/read`, {
      method: "PATCH",
      credentials: "include",
      headers: {
        Accept: "application/json",
        Authorization: `Bearer ${token}`,
        "X-XSRF-TOKEN": xsrfToken,
      },
    });

    if (!response.ok) {
      throw new Error(`HTTP ${response.status}`);
    }

    const notification = notifications.value.find((item) => item.id === id);

    if (notification) {
      notification.unread = false;
    }
  } catch (error) {
    console.error("Gagal menandai notifikasi sebagai dibaca:", error);
  }
}

async function markAllAsRead() {
  try {
    const token = localStorage.getItem("token");
    const xsrfToken = await getCsrfToken();

    const response = await fetch(`${API_NOTIFICATIONS}/read-all`, {
      method: "PATCH",
      credentials: "include",
      headers: {
        Accept: "application/json",
        Authorization: `Bearer ${token}`,
        "X-XSRF-TOKEN": xsrfToken,
      },
    });

    if (!response.ok) {
      throw new Error(`HTTP ${response.status}`);
    }

    notifications.value.forEach((notification) => {
      notification.unread = false;
    });
  } catch (error) {
    console.error("Gagal menandai semua notifikasi:", error);
  }
}

async function deleteNotification(id) {
  try {
    const token = localStorage.getItem("token");
    const xsrfToken = await getCsrfToken();
    
    const response = await fetch(`${API_NOTIFICATIONS}/${id}`, {
      method: "DELETE",
      credentials: "include",
      headers: {
        Accept: "application/json",
        Authorization: `Bearer ${token}`,
        "X-XSRF-TOKEN": xsrfToken,
      },
    });

    if (!response.ok) {
      throw new Error(`HTTP ${response.status}`);
    }

    notifications.value = notifications.value.filter(
      (notification) => notification.id !== id,
    );
  } catch (error) {
    console.error("Gagal menghapus notifikasi:", error);
  }
}

export function useNotifications() {
  onMounted(async () => {
    await loadNotifications();

    // Cek notifikasi baru setiap 5 detik
    notificationInterval = setInterval(() => {
      loadNotifications();
    }, 15000);
  });

  onUnmounted(() => {
    if (notificationInterval) {
      clearInterval(notificationInterval);
      notificationInterval = null;
    }
  });

  return {
    notifications,
    notificationCount,
    loading,
    errorMessage,
    loadNotifications,
    markAsRead,
    markAllAsRead,
    deleteNotification,
  };
}
