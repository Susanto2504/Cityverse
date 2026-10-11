import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import tailwindcss from "@tailwindcss/vite";
import vueDevTools from 'vite-plugin-vue-devtools'

// https://vite.dev/config/
export default defineConfig({
  plugins: [vue(), tailwindcss(), vueDevTools()],
  resolve: {
    alias: {
      "@": fileURLToPath(new URL("./src", import.meta.url)),
    },
  },
  server: {
    port: 5174,
    strictPort: true,
    proxy: {
      "/backend": {
        target: "https://datacityverse.mypoli.web.id/",
        changeOrigin: true,
        secure: true,
        cookieDomainRewrite: "localhost",
        rewrite: (path) => path.replace(/^\/backend/, ""),
      },
      "/api-klh": {
        target: "https://satudata.kemenlh.go.id",
        changeOrigin: true,
        secure: true,
        rewrite: (path) => path.replace(/^\/api-klh/, ""),
      },
      "/api-makassar": {
        target: "https://data.makassarkota.go.id",
        changeOrigin: true,
        secure: true,
        rewrite: (path) => path.replace(/^\/api-makassar/, ""),
      },

      "/satu-data": {
        target: "https://datacityverse.mypoli.web.id",
        changeOrigin: true,
        secure: true,
        rewrite: (path) => path.replace(/^\/satu-data/, ""),
      },
    },
  },
});
