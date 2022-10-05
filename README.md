# BCP_creatorとは

ケアサポートマネジメントシステム社のBCP文書管理システムのプロジェクトです。

## BCPとは

BCP（事業継続計画）とは、企業が自然災害、大火災、テロ攻撃などの緊急事態に遭遇した場合において、事業資産の損害を最小限にとどめつつ、中核となる事業の継続あるいは早期復旧を可能とするために、平常時に行うべき活動や緊急時における事業継続のための方法、手段などを取り決めておく計画のことです。

https://www.chusho.meti.go.jp/bcp/contents/level_c/bcpgl_01_1.html

## プロジェクトの構成

プロジェクト全体がDockerを使って構築されています。
本プロジェクトはフルタック型ウェブシステムです。
以下のDockerコンテナから構成されます。

- db
  - RDBサーバー(mysql, MariaDB)
- nginx
  - ウェブサーバー(nginx)
- php
  - ウェブサービス本体
  - php-8.1
  - Laravel 9


## Dockerの構成

`docker-compose.yml` を参照。

- php
  - ウェブサービス本体が格納されるコンテナ
- nginx
  - ウェブサーバー前段となるnginxのコンテナ
- db
  - bcp_creator のデータベース(MySQL/MariaDB)

### 初期設定までのセットアップ

- Dockerのインストール
  - https://www.docker.com/products/docker-desktop/
- Visual Studio Codeのインストール(本プロジェクトの標準エディタ)
- Windows
  - MSYS2のインストール
  - https://www.msys2.org/
  - Git for Windowsのインストール(MSYS2のgitでもよい)
  - https://gitforwindows.org/
  - "Checkout as-is, comment Unix-style line endings"を選択してください
  - https://qiita.com/uggds/items/00a1974ec4f115616580
  - docker-composeのインストール
- Mac
  - brewのインストール
  - gitのインストール
  - docker-composeのインストール

## docker-composeの注意点

Docker Desktopにバンドルされるdocker-composeがv1系である場合、
MSYS2やbrewを使って2系をインストールして差し替える必要があります。

以下、brewの場合。

```bash
brew install docker-compose
brew unlink docker-compose
brew link --force --overwrite docker-compose
```

### Windowsの注意点

```
$ git config -l
```
を実行し、 `core.autocrlf=true`になっている場合、正常に運用できないため

```bash
$ git config --global core.autocrlf input
```

に変更しておくこと。

### 初期設定

- 本プロジェクトのリポジトリをクローンする
- Dockerコンテナのセットアップ

```bash
$ cd bcp_creator
$ cd creator
$ cp .env.local .env
$ cd ..
$ docker-compose up -d
```

- Docker内にログインする
- composer で phpモジュールをセットアップする

```bash
$ docker-compose exec app bash
# cd creator
# composer install
```

## Add your files

-- [ ] [Create](https://docs.gitlab.com/ee/user/project/repository/web_editor.html#create-a-file) or [upload](https://docs.gitlab.com/ee/user/project/repository/web_editor.html#upload-a-file) files
-- [ ] [Add files using the command line](https://docs.gitlab.com/ee/gitlab-basics/add-file.html#add-a-file-using-the-command-line) or push an existing Git repository with the following command:
