import { createRouter, createWebHistory } from "vue-router";

import HomeView from "../views/HomeView.vue";
import DashboardView from "../views/DashboardView.vue";
import ConfigView from "../views/ConfigView.vue";
import SimulationView from "../views/SimulationView.vue";
import LaporanView from "../views/LaporanView.vue";
import SettingsView from "../views/SettingsView.vue";
import LoginView from "../views/LoginView.vue";

import DataJalan from "../components/data/DataJalan.vue";
import DataCuaca from "../components/data/DataCuaca.vue";
import DataLingkungan from "../components/data/DataLingkungan.vue";
import DataInfrastruktur from "../components/data/DataInfrastruktur.vue";

import { getUser } from "@/services/api";

const routes = [
  {
    path: "/",
    name: "home",
    component: HomeView,
  },

  {
    path: "/login",
    name: "login",
    component: LoginView,
    meta: {
      guest: true,
    },
  },

  {
    path: "/dashboard",
    name: "dashboard",
    component: DashboardView,
    meta: {
      requiresAuth: true,
    },
  },

  {
    path: "/config",
    name: "config",
    component: ConfigView,
    meta: {
      requiresAuth: true,
    },
    children: [
      {
        path: "jalan",
        name: "data-jalan",
        component: DataJalan,
        meta: {
          requiresAuth: true,
        },
      },
      {
        path: "cuaca",
        name: "data-cuaca",
        component: DataCuaca,
        meta: {
          requiresAuth: true,
        },
      },
      {
        path: "lingkungan",
        name: "data-lingkungan",
        component: DataLingkungan,
        meta: {
          requiresAuth: true,
        },
      },
      {
        path: "infrastruktur",
        name: "data-infrastruktur",
        component: DataInfrastruktur,
        meta: {
          requiresAuth: true,
        },
      },
    ],
  },

  {
    path: "/simulation",
    name: "simulation",
    component: SimulationView,
    meta: {
      requiresAuth: true,
    },
  },

  {
    path: "/laporan",
    name: "laporan",
    component: LaporanView,
    meta: {
      requiresAuth: true,
    },
  },

  {
    path: "/settings",
    name: "settings",
    component: SettingsView,
    meta: {
      requiresAuth: true,
    },
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

// ==========================================
// AUTH GUARD
// ==========================================

router.beforeEach(async (to) => {
  try {

    await getUser();

    if (to.meta.guest) {
      return {
        name: "dashboard",
      };
    }

    return true;
  } catch (error) {
    
    if (to.meta.requiresAuth) {
      return {
        name: "login"
      };
    }

    return true;
  }
});

export default router;
