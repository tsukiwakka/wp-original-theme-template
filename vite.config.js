import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'
import { resolve } from 'path'
import { fileURLToPath } from 'url'

const __dirname = fileURLToPath(new URL('.', import.meta.url))

export default defineConfig({
  plugins: [tailwindcss()],

  // root を theme/src にすることで、Viteの監視・HMRが theme/src 配下に効く
  // ※ ビルドの input / outDir は絶対パスで明示するため root があっても問題なし
  root: resolve(__dirname, 'theme/src'),

  build: {
    outDir:     resolve(__dirname, 'theme/dist'),
    emptyOutDir: true,
    manifest:    true,
    rollupOptions: {
      input: {
        main:     resolve(__dirname, 'theme/src/js/main.js'),
        style:    resolve(__dirname, 'theme/src/scss/style.scss'),
        tailwind: resolve(__dirname, 'theme/src/css/tailwind.css'),
      },
      output: {
        entryFileNames: 'js/[name]-[hash].js',
        chunkFileNames: 'js/[name]-[hash].js',
        assetFileNames: (info) => {
          if (info.name?.endsWith('.css'))                           return 'css/[name]-[hash][extname]'
          if (/\.(png|jpe?g|gif|svg|webp|ico)$/.test(info.name ?? '')) return 'images/[name]-[hash][extname]'
          return 'assets/[name]-[hash][extname]'
        },
      },
    },
  },

  server: {
    port:        5173,
    strictPort:  true,
    // WordPressのHTML(localhost:8080 or 3000)からViteのアセットを取得できるよう公開
    origin:      'http://localhost:5173',
    hmr: {
      host: 'localhost',
      port: 5173,
    },
    watch: {
      // theme/dist は除外（ビルド成果物の変更で無限ループ防止）
      ignored: [resolve(__dirname, 'theme/dist/**')],
    },
  },

  resolve: {
    alias: {
      '@':     resolve(__dirname, 'theme/src'),
      '@scss': resolve(__dirname, 'theme/src/scss'),
      '@js':   resolve(__dirname, 'theme/src/js'),
    },
  },
})
