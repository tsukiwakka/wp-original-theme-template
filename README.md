# WordPress オリジナルテーマ 開発テンプレート

Vite + Tailwind CSS v4 + SCSS + Docker によるモダンなWordPress テーマ開発テンプレートです。

## 技術スタック

| カテゴリ | 採用技術 |
|---------|---------|
| CMS | WordPress（素のPHP） |
| ビルドツール | Vite 6 |
| CSS | Tailwind CSS v4 + SCSS/Sass |
| JavaScript | バニラJS（ES Modules） |
| ローカル環境 | Docker Compose |
| CI/CD | GitHub Actions |

## 特徴

- ✅ **HMR（Hot Module Replacement）** — JS・CSS変更時にブラウザが自動リフレッシュ
- ✅ **マニフェスト連携** — 本番ビルドでハッシュ付きファイル名を自動管理
- ✅ **Tailwind + SCSS 共存** — ユーティリティクラスとカスタムスタイルを使い分け
- ✅ **AI駆動開発対応** — `CLAUDE.md` でAIアシスタントにコンテキストを提供
- ✅ **GitHub Actions** — プッシュ時に自動でビルド・Lintチェック

## クイックスタート

### 前提条件

- Docker Desktop
- Node.js 20+
- Git

### セットアップ

```bash
# 1. テンプレートをclone（またはUse this template）
git clone https://github.com/yourname/wp-theme-template.git my-project
cd my-project

# 2. 環境変数の設定
cp .env.example .env
# .env の THEME_SLUG を任意のテーマ名に変更

# 3. Node モジュールのインストール
npm install

# 4. Docker でWordPress起動
docker compose up -d

# 5. WordPress初期設定
# http://localhost:8080 にアクセスしてインストーラーを実行

# 6. テーマを有効化
# WordPress管理画面 → 外観 → テーマ → 有効化

# 7. Vite 開発サーバー起動（HMR有効）
bash dev-server.sh
```

### 開発コマンド

```bash
bash dev-server.sh   # 開発サーバー起動（HMR + PHPファイル監視）
npm run build        # 本番ビルド
npm run lint:js      # JavaScript Lint
npm run lint:css     # SCSS Lint
```

## ディレクトリ構成

```
.
├── theme/                    # WordPressテーマ（wp-content/themes/にマウント）
│   ├── src/
│   │   ├── js/               # JavaScriptソース
│   │   └── scss/             # SCSSソース（Tailwindエントリーも含む）
│   ├── dist/                 # Viteビルド出力（gitignore済み）
│   ├── inc/                  # PHPインクルード（テンプレートタグ等）
│   ├── parts/                # テンプレートパーツ
│   └── functions.php         # テーマ設定・Viteアセット統合
├── docker/                   # Docker設定ファイル
├── .github/workflows/        # GitHub Actions
├── vite.config.js
├── docker-compose.yml
├── CLAUDE.md                 # AI駆動開発用コンテキスト
└── README.md
```

## HMR（自動リフレッシュ）の仕組み

```
ファイル変更
  ↓
Vite が検知（JS・SCSS・PHP）
  ↓
JS/CSS → HMRでブラウザに即反映（リロードなし）
PHP    → フルリロード
  ↓
WordPress（localhost:8080）に自動反映
```

## 本番デプロイ

```bash
npm run build
# theme/dist/ 以下のファイルをサーバーにデプロイ
# theme/ ディレクトリ全体をWordPressのthemesディレクトリに配置
```

## ライセンス

GPL v2 or later
