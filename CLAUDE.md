# CLAUDE.md — AI駆動開発コンテキスト

このファイルはClaude Code（またはその他のAIコーディングアシスタント）がこのリポジトリの構造・規約・開発フローを理解するためのドキュメントです。

---

## プロジェクト概要

WordPressオリジナルテーマの開発テンプレートリポジトリ。

| 項目 | 内容 |
|------|------|
| CMS | WordPress（素のPHP） |
| ビルドツール | Vite 6 |
| CSS | Tailwind CSS v4 + SCSS/Sass |
| JS | バニラJS（ES Modules） |
| ローカル環境 | Docker Compose |
| ソース管理 | GitHub |

---

## ディレクトリ構成

```
wp-theme-template/
├── theme/                    # WordPress テーマ本体
│   ├── src/
│   │   ├── js/               # JavaScript ソース
│   │   │   ├── main.js       # エントリーポイント
│   │   │   └── modules/      # モジュール分割
│   │   └── scss/             # SCSS ソース
│   │       ├── style.scss    # エントリーポイント
│   │       ├── abstracts/    # 変数・ミックスイン
│   │       ├── base/         # リセット・タイポグラフィ
│   │       ├── components/   # UIコンポーネント
│   │       ├── layout/       # レイアウト
│   │       └── pages/        # ページ固有スタイル
│   ├── dist/                 # Viteビルド出力（gitignore済み）
│   ├── inc/                  # PHP インクルードファイル
│   ├── parts/                # テンプレートパーツ
│   ├── templates/            # カスタムページテンプレート
│   ├── functions.php         # テーマ設定（Viteアセット統合含む）
│   ├── style.css             # WordPressテーマヘッダーのみ
│   ├── index.php             # メインテンプレート
│   ├── single.php            # 投稿詳細
│   ├── header.php            # ヘッダー
│   └── footer.php            # フッター
├── docker-compose.yml        # Docker設定
├── vite.config.js            # Vite設定
├── package.json
├── .env.example              # 環境変数テンプレート
└── dev-server.sh             # 開発サーバー起動スクリプト
```

---

## 開発コマンド

```bash
# Docker起動（初回）
docker compose up -d

# 開発サーバー起動（Vite HMR有効）
bash dev-server.sh       # または npm run dev

# 本番ビルド
npm run build

# WordPress確認
open http://localhost:8080
```

---

## Vite × WordPress の統合方式

### 開発時（HMR）
1. `dev-server.sh` を実行 → `theme/.vite-dev-server` ファイルが作成される
2. `functions.php` の `theme_is_vite_dev()` がこのファイルを検知
3. WordPressのHTML内に Vite dev server (`localhost:5173`) からのアセットが差し込まれる
4. JS・CSS を変更すると**ブラウザが自動リフレッシュ**される
5. PHPファイルの変更は `vite.config.js` の `watch.include` が検知してリロードを促す

### 本番時（ビルド）
1. `npm run build` → `theme/dist/.vite/manifest.json` が生成される
2. `functions.php` がマニフェストを読み込み、ハッシュ付きファイル名でエンキュー

---

## コーディング規約

### PHP
- WordPress コーディング規約に準拠
- 関数名プレフィックス: `theme_` を使用（例: `theme_posted_on()`）
- テキストドメイン: `my-theme`
- エスケープ: 必ず `esc_html()`, `esc_url()`, `esc_attr()` を使用
- 直接アクセス防止: すべてのPHPファイルに `defined('ABSPATH') || exit;` を先頭に記述

### JavaScript
- ES Modules形式（`import/export`）
- `theme/src/js/modules/` に機能ごと分割
- DOM操作は `data-*` 属性でセレクタを指定（classの多重利用を避ける）

### CSS（SCSS + Tailwind）
- ユーティリティクラスは Tailwind を優先使用
- コンポーネント固有の複雑なスタイルは SCSS に記述
- SCSS変数は `abstracts/_variables.scss` に集約
- ミックスインは `abstracts/_mixins.scss` に集約
- BEM命名規則は使用しない（Tailwindと相性が悪い）

---

## 新しいテンプレートを追加する手順

### 例: お問い合わせページ

1. `theme/page-contact.php` を作成（WordPressのページテンプレート）
2. 必要に応じて `theme/parts/contact-form.php` を作成
3. スタイルは `theme/src/scss/pages/_contact.scss` に記述
4. `theme/src/scss/style.scss` に `@use "pages/contact"` を追記

---

## Docker環境の詳細

| サービス | URL | 用途 |
|---------|-----|------|
| WordPress | http://localhost:8080 | メインサイト |
| phpMyAdmin | http://localhost:8081 | DB管理 |
| Vite HMR | http://localhost:5173 | アセット配信（開発時のみ） |

### WordPress初期設定手順
1. `docker compose up -d`
2. http://localhost:8080 にアクセスしてWordPressインストーラーを実行
3. テーマ → 外観 → テーマ → `my-theme` を有効化

---

## よくある質問

**Q: CSSが反映されない**
→ 開発時は `bash dev-server.sh` が起動しているか確認。本番ビルドは `npm run build` を実行。

**Q: PHPファイルの変更がリフレッシュされない**
→ Vite dev serverのwatcher設定で `.php` ファイルも監視しているが、ブラウザをリロードしてください。

**Q: テーマスラッグを変えたい**
→ `.env` の `THEME_SLUG` を変更し、`docker compose down && docker compose up -d` で再起動。
