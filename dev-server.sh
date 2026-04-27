#!/usr/bin/env bash
set -e

SIGNAL_FILE="./theme/.vite-dev-server"

cleanup() {
  echo ""
  echo "🛑 開発サーバーを停止します..."
  rm -f "$SIGNAL_FILE"
  exit 0
}
trap cleanup SIGINT SIGTERM

touch "$SIGNAL_FILE"

echo ""
echo "🚀 開発サーバーを起動します..."
echo ""
echo "  ブラウザは http://localhost:8080 を開いてください"
echo ""
echo "  localhost:8080  ... WordPress 本体"
echo "  localhost:5173  ... Vite（JS/SCSS HMR）"
echo "  ※ Browser-syncのプロキシは使いません"
echo ""

npm run dev

cleanup
