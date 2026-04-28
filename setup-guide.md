# 開発環境セットアップガイド
## WordPress テーマ開発 — Mac向け手順書

---

## 必要なツール一覧

| ツール | 用途 | バージョン |
|--------|------|-----------|
| mise | Node.jsのバージョン管理 | 最新版 |
| Node.js | フロントエンドビルドツールの実行 | 20系（miseで自動管理） |
| Docker Desktop | WordPressのローカル実行環境 | 最新版 |
| Git | ソースコード管理 | macOS標準 |

> Node.jsはmise経由でインストールするため、Node.jsを直接インストールする必要はありません。

---

## 1. Homebrewのインストール

macOSのパッケージマネージャーです。ターミナルを開いて以下を実行してください。

```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

インストール後、ターミナルに表示される「Next steps」の指示に従ってPATHを設定してください（Apple Siliconの場合は必須です）。

確認：

```bash
brew --version
# Homebrew 4.x.x と表示されればOK　（バージョン名は更新とともにかわるので、バージョンが表示されればOK）
```

---

## 2. miseのインストール（Node.jsバージョン管理）

miseはNode.jsなど複数の言語ランタイムをバージョン管理できるツールです。以前よく使われていたVoltaはメンテナンスが終了したため、現在はmiseを推奨しています。

### インストール

```bash
brew install mise
```

### シェルへの設定追加

macOSのデフォルトシェルはzshです。以下を実行してください。

```bash
echo 'eval "$(mise activate zsh)"' >> ~/.zshrc
source ~/.zshrc
```

確認：

```bash
mise --version
# mise yyyy.x.x と表示されればOK（バージョン名は更新とともにかわるので、バージョンが表示されればOK）
```

---

## 3. Node.jsのインストール（mise経由）

```bash
mise install node@20
mise use --global node@20
```

確認：

```bash
node --version
# v20.x.x と表示されればOK

npm --version
# 10.x.x と表示されればOK（バージョン名は更新とともにかわるので、バージョンが表示されればOK）
```

---

## 4. Docker Desktopのインストール

ローカルでWordPressを動かすためのツールです。以下のURLからダウンロードしてください。

```
https://www.docker.com/products/docker-desktop/
```

### Apple Silicon / Intel の確認方法

Appleメニュー →「このMacについて」→ チップの項目を確認してください。

| チップの表示 | 選択するインストーラー |
|---|---|
| Apple M1 / M2 / M3 など | Mac（Apple Silicon）版 |
| Intel | Mac（Intel）版 |

ダウンロードした `.dmg` ファイルを開き、Docker.app を Applicationsフォルダにドラッグしてインストールします。インストール後 Docker Desktop を起動し、メニューバーにクジラのアイコンが表示されれば完了です。

確認：

```bash
docker --version
# Docker version 27.x.x と表示されればOK（バージョン名は更新とともにかわるので、バージョンが表示されればOK）

docker compose version
# Docker Compose version v2.x.x と表示されればOK（バージョン名は更新とともにかわるので、バージョンが表示されればOK）
```

---

## 5. Gitの確認

macOSにはGitが標準搭載されています。以下を実行してください。

```bash
git --version
```

インストールを促すダイアログが表示された場合は「インストール」をクリックしてください。

GitHubのアカウントをお持ちでない場合は https://github.com でアカウントを作成してください。

---

## 6. プロジェクトのセットアップ

### リポジトリをクローン

```bash
git clone https://github.com/yourname/wp-theme-template.git
cd wp-theme-template
```

### 環境変数ファイルの作成

```bash
cp .env.example .env
```

`.env` ファイルはそのまま使用できます。ポートが競合する場合は `WP_PORT` の番号を変更してください。

### Node.jsパッケージのインストール

```bash
npm install
```

### WordPressの起動

```bash
docker compose up -d
```

初回はWordPressのイメージダウンロードに数分かかります。

### WordPressの初期設定

ブラウザで以下にアクセスしてインストーラーを開きます。

```
http://localhost:8080/wp-admin/install.php
```

データベース接続情報は以下を入力してください。
（スキップで良いです。DBに直接はいるなどしたいとき以外はあまり意識しない部分です。MySQLのGUIツールでアクセスしたいときに接続情報として必要なものがあります）

| 項目 | 値 |
|------|-----|
| データベース名 | wordpress |
| ユーザー名 | wpuser |
| パスワード | wppassword |
| データベースのホスト | db |
| テーブル接頭辞 | wp_（そのまま） |

続けてサイト名・管理者アカウントを設定してインストールを完了してください。

### テーマを有効化

WordPress管理画面 → 外観 → テーマ →「My Theme」を有効化

---

## 7. 開発サーバーの起動

```bash
bash dev-server.sh
```

ブラウザで `http://localhost:8080` を開いてください。

| 変更ファイル | 動作 |
|---|---|
| PHPファイル | ページが自動でリロード |
| SCSS | リロードなしで即時反映 |
| JavaScript | リロードなしで即時反映 |

---

## 8. 日常の開発フロー

```bash
# 開発開始時
docker compose up -d    # WordPress起動（毎回必要）
bash dev-server.sh      # 開発サーバー起動

# 作業終了時
Ctrl + C                # 開発サーバー停止
docker compose down     # Docker停止（任意）
```

---

## トラブルシューティング

**`docker compose up -d` でエラーが出る**
→ Docker Desktopが起動しているか確認してください（メニューバーのクジラアイコンが静止していればOK）

**`http://localhost:8080` にアクセスできない**
→ `docker compose ps` でコンテナが起動しているか確認してください

**ポートが競合するエラーが出る**
→ `.env` の `WP_PORT=8080` を別の番号（例：`8090`）に変更して `docker compose up -d` を再実行してください

**`npm install` でエラーが出る**
→ `node --version` で `v20.x.x` と表示されているか確認してください。表示されない場合は手順3からやり直してください
