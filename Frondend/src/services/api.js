const API_BASE = import.meta.env.VITE_API_URL;

function getCookie(name) {
  const cookies = document.cookie.split("; ");

  const cookie = cookies.find((row) => row.startsWith(`${name}=`));

  return cookie ? decodeURIComponent(cookie.substring(name.length + 1)) : null;
}

export async function getCsrfCookie() {
  const response = await fetch(`${API_BASE}/sanctum/csrf-cookie`, {
    method: "GET",
    credentials: "include",
    headers: {
      Accept: "application/json",
    },
  });

  if (!response.ok) {
    throw new Error("Gagal mendapatkan CSRF cookie.");
  }

  const token = getCookie("XSRF-TOKEN");

  if (!token) {
    throw new Error("Cookie XSRF-TOKEN tidak dapat dibaca.");
  }

  return token;
}

export async function login(email, password) {
  await getCsrfCookie();

  const xsrfToken = getCookie("XSRF-TOKEN");

  if (!xsrfToken) {
    throw new Error("Cookie XSRF-TOKEN tidak ditemukan.");
  }

  const response = await fetch(`${API_BASE}/api/login`, {
    method: "POST",
    credentials: "include",
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
      "X-XSRF-TOKEN": xsrfToken,
    },
    body: JSON.stringify({ email, password }),
  });

  const data = await response.json().catch(() => ({}));

  if (!response.ok) {
    throw new Error(data.message || `Login gagal. HTTP ${response.status}`);
  }

  return data;
}

export async function getUser() {
  const response = await fetch(`${API_BASE}/api/user`, {
    method: "GET",
    credentials: "include",
    headers: {
      Accept: "application/json",
    },
  });

  const text = await response.text();

  let data;

  try {
    data = JSON.parse(text);
  } catch {
    throw new Error(
      `API /api/user mengembalikan respons bukan JSON. HTTP ${response.status}.`,
    );
  }

  if (!response.ok) {
    throw new Error(data.message || "Belum login.");
  }

  return data;
}

export async function logout() {
  const xsrfToken = getCookie("XSRF-TOKEN");

  const response = await fetch(`${API_BASE}/api/logout`, {
    method: "POST",
    credentials: "include",
    headers: {
      Accept: "application/json",
      "X-XSRF-TOKEN": xsrfToken,
    },
  });

  const data = await response.json();

  if (!response.ok) {
    throw new Error(data.message || "Logout gagal.");
  }

  return data;
}
