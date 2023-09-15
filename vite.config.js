import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue()],
  root: 'documentation',
  build: {
    outDir: '../docs'
  },
  base: '/stream-games-42/',
  server: {
    open: '/index.html'
  }
})
