/**
 * bs-watch.mjs
 * PHP ファイルの変更を監視し、Vite の WebSocket 経由でリロードを送信する
 *
 * Browser-sync のプロキシは使わない。
 * Vite dev server (5173) に接続したブラウザへ full-reload を送るだけ。
 * ブラウザは localhost:8080 を直接開く。
 *
 * 仕組み:
 *   1. chokidar で theme/**\/*.php を監視
 *   2. 変更検知 → Vite の WebSocket (/vite-hmr) に full-reload メッセージ送信
 *   3. ブラウザ（Vite HMR クライアント接続済み）がリロード
 */

import chokidar from 'chokidar'
import { WebSocket } from 'ws'
import { resolve, dirname } from 'path'
import { fileURLToPath } from 'url'

const __dirname = dirname(fileURLToPath(import.meta.url))

const VITE_PORT = 5173
const VITE_WS_URL = `ws://localhost:${VITE_PORT}/__vite_hmr`

// PHPファイルの変更を検知してVite経由でリロード
const watcher = chokidar.watch(
  resolve(__dirname, 'theme/**/*.php'),
  {
    ignoreInitial: true,
    ignored: [resolve(__dirname, 'theme/dist/**')],
  }
)

let wsClient = null

function connectWS() {
  wsClient = new WebSocket(VITE_WS_URL)
  wsClient.on('open', () => {
    console.log('[PHP-watch] Vite WebSocket に接続しました')
  })
  wsClient.on('error', () => {
    // Vite 未起動時は再試行
    setTimeout(connectWS, 2000)
  })
  wsClient.on('close', () => {
    setTimeout(connectWS, 2000)
  })
}

connectWS()

watcher.on('change', (filePath) => {
  const rel = filePath.replace(__dirname, '')
  console.log(`[PHP-watch] 変更検知: ${rel}`)

  if (wsClient?.readyState === WebSocket.OPEN) {
    wsClient.send(JSON.stringify({ type: 'full-reload', path: '*' }))
    console.log('[PHP-watch] → ブラウザにリロードを送信しました')
  } else {
    console.log('[PHP-watch] → WebSocket未接続。Viteが起動しているか確認してください')
  }
})

console.log(`
┌─────────────────────────────────────────────────────────┐
│  PHP ファイルウォッチャー起動                           │
│                                                         │
│  ブラウザ:   http://localhost:8080  ← ここを開く        │
│  Vite HMR:   http://localhost:5173                      │
│                                                         │
│  PHP変更     → Vite 経由でフルリロード                  │
│  SCSS変更    → Vite HMR で即時反映（ちらつきなし）      │
│  JS変更      → Vite HMR で即時反映（ちらつきなし）      │
└─────────────────────────────────────────────────────────┘
`)
