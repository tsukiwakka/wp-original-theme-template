/**
 * main.js
 * テーマのメインJavaScriptエントリーポイント
 */

// Tailwind CSS（Sassとは分離した専用ファイル）
import '@/css/tailwind.css'

// SCSSをimport → ViteがSCSSのHMRを担当
import '@scss/style.scss'

import './modules/navigation'
import './modules/scroll'

if (import.meta.hot) {
  import.meta.hot.accept(() => {
    console.log('[HMR] updated')
  })
}

console.log('[Theme] JavaScript loaded ✅')
