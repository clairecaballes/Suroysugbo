import tailwindcss from "@tailwindcss/vite";
import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import dotenv from 'dotenv';
import vue from '@vitejs/plugin-vue';
import path from 'path'; // <-- Use ESM import

export default (mode) => {
   // Load environment variables explicitly
   dotenv.config({ path: `.env.${mode}` });
   dotenv.config(); // Fallback to default `.env` file

   process.env = { ...process.env, ...loadEnv(mode, process.cwd()) };

   return defineConfig({
      plugins: [
         laravel({
            input: ["resources/js/app.ts"],
            ssr: "resources/js/ssr.ts",
            refresh: true,
         }),
         tailwindcss(),
         vue({
            template: {
               transformAssetUrls: {
                  base: null,
                  includeAbsolute: false,
               },
            },
         }),
      ],
      resolve: {
         alias: {
            "@": path.resolve(__dirname, "./resources/js"),
            "ziggy-js": path.resolve(__dirname, "vendor/tightenco/ziggy"),
         },
      },
      server: {
         host: process.env.APP_DNS,
         port: parseInt(process.env.VITE_PORT || "5173"),
         hmr: {
            host: process.env.APP_DNS || "localhost",
         },
      },
   });
};