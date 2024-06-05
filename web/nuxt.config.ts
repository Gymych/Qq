import { resolve } from "path";
// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  ssr: false,
  vite: {
    resolve: {
      alias: {
        "@": resolve(__dirname, "./"),
        "@components": resolve(__dirname, "./components"),
        "@assets": resolve(__dirname, "./assets"),
      },
    },
  },
  modules: ["@nuxt/eslint", "shadcn-nuxt", "@pinia/nuxt"],
  shadcn: {
    prefix: "",
    componentDir: "./components/ui",
  },
  css: ["@/assets/css/main.css"],
  postcss: {
    plugins: {
      tailwindcss: {},
      autoprefixer: {},
    },
  },
  runtimeConfig: {
    public: {
      apiBaseUrl:
        process.env.NUXT_PUBLIC_API_URL || "http://localhost:8000/api",
    },
  },
});
