# デプロイ設定手順

## 1. SSH キーペアを生成

ローカルで実行（既存のキーと混在しないよう専用キーを作成推奨）:

```bash
ssh-keygen -t ed25519 -C "github-actions-deploy" -f ~/.ssh/github_deploy
# パスフレーズは空のままEnter（Actions から使うため）
```

生成されるファイル:
- `~/.ssh/github_deploy`       ← 秘密鍵（GitHub Secrets に登録）
- `~/.ssh/github_deploy.pub`   ← 公開鍵（レンタルサーバーに登録）

## 2. 公開鍵をレンタルサーバーに登録

```bash
# サーバーにSSH接続して
cat ~/.ssh/github_deploy.pub >> ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys
```

またはレンタルサーバーの管理画面の「SSH公開鍵登録」から追加。

## 3. GitHub Secrets に登録

リポジトリの Settings → Secrets and variables → Actions → New repository secret

| Secret 名      | 値の例                                      | 説明                        |
|----------------|---------------------------------------------|-----------------------------|
| SSH_PRIVATE_KEY | `~/.ssh/github_deploy` の中身をまるごとコピー | 秘密鍵                      |
| SSH_HOST        | `example.com` または IPアドレス             | サーバーのホスト名          |
| SSH_PORT        | `22`                                        | SSHポート（通常22）         |
| SSH_USER        | `your-username`                             | SSHユーザー名               |
| DEPLOY_PATH     | `/home/user/public_html/wp-content/themes/my-theme` | テーマの絶対パス |

## 4. デプロイパスの確認

レンタルサーバーにSSH接続して確認:

```bash
# WordPress がインストールされているパスを確認
find / -name "wp-config.php" 2>/dev/null

# テーマディレクトリのパスを確認（例）
ls /home/username/public_html/wp-content/themes/
```

DEPLOY_PATH は `wp-content/themes/テーマ名` の絶対パスを指定。

## 5. 動作確認

```bash
# main ブランチにマージ or push するとデプロイが走る
git checkout main
git merge develop
git push origin main

# GitHub の Actions タブでログを確認
```

## レンタルサーバー別メモ

### さくらインターネット
- SSH接続: 標準で対応（ポート22）
- 管理画面: サーバコントロールパネル → SSH設定

### エックスサーバー
- SSH接続: 対応（ポート10022 の場合あり）
- SSH_PORT に `10022` を設定する

### ロリポップ
- SSH接続: スタンダード以上のプランで対応
- SSH_PORT に `2222` を設定する場合あり
