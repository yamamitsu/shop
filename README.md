# BCP_creatorとは

ケアサポートマネジメントシステム社のBCP文書管理システムのプロジェクトです。

## BCPとは

BCP（事業継続計画）とは、企業が自然災害、大火災、テロ攻撃などの緊急事態に遭遇した場合において、事業資産の損害を最小限にとどめつつ、中核となる事業の継続あるいは早期復旧を可能とするために、平常時に行うべき活動や緊急時における事業継続のための方法、手段などを取り決めておく計画のことです。

https://www.chusho.meti.go.jp/bcp/contents/level_c/bcpgl_01_1.html

## プロジェクトの構成

プロジェクト全体がDockerを使って構築されています。
本プロジェクトはフルタック型ウェブシステムです。
以下のDockerコンテナから構成されます。

- php
  - ウェブサービス本体
  - php-8.1
  - Laravel 9
  - composer内蔵。composer, artisanを実行するときはコンテナ内で実行すること。
- db
  - RDBサーバー(mysql, MariaDB)
- nginx
  - ウェブサーバー(nginx)


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
  - "Checkout as-is, comment Unix-style line endings"を選択
  - https://qiita.com/uggds/items/00a1974ec4f115616580
  - docker-composeのインストール
- Mac
  - brewのインストール
  - gitのインストール
  - docker-composeのインストール

## docker-composeの注意点

Docker Desktopにバンドルされるdocker-composeがv1系である場合、
brew等を使って2系をインストールして差し替える必要があります。

### docxker-compose の更新(Windows)

MSYS2等に収録されていないようなので、開発元から直接入手します。
https://github.com/docker/compose/releases

- 最新版の `docker-compose-windows-x86_64.exe` をダウンロード
- PATHの通っているディレクトリにファイルを移動
- `docker-compose.exe` にファイル名を変更
- `$ docker-compose version` を実行してv2系に差し替わっていることを確認

### docxker-compose の更新(Mac)

以下、brewの場合。(おそらく初期状態ではdocker-compose v1系が実行される状態)

```bash
$ brew install docker-compose
$ brew unlink docker-compose
$ brew link --force --overwrite docker-compose
```

### Windowsの注意点(git)

```
$ git config -l
```
を実行し、 `core.autocrlf=true`になっている場合、正常に運用できないため

```bash
$ git config --global core.autocrlf input
```

git configは system/global/local の3段階の設定となっているため、local含めて設定値が上書きされていないか確認すること。

に変更しておくこと。

この作業はリポジトリをクローンする前に実施する必要があります。

### 初期設定

- 本プロジェクトのリポジトリをクローンする
- .env のセットアップ
- Dockerコンテナのセットアップ
- composerのセットアップ

```bash
$ git clone https://gitlab.com/libertyfish/bcp_creator.git
$ cd bcp_creator
$ cd creator
$ cp .env.local .env
$ cd ..
$ docker-compose up -d --build
$ docker-compose exec app composer install
```

### composer

composer.json は `/creator` 以下で構築されており、Laravel 9アプリでもある。
`app` コンテナ内で実行すること。

例： 新しいパッケージをインストールする

実施方法1: ホスト側から間接的にdocker内のcomposerを実行する

```bash
$ docker-compose exec app composer require laravelcollective/html
```

実施方法2: appコンテナ内でcomposerを実行する

```bash
$ docker-compose exec app bash
# composer require laravelcollective/html
```

### artisan

artisanは dockerと同じく `/creator` ディレクトリ以下で実行できる。
`app` コンテナ内で実行すること。

例: ウェブアプリのルート設定の確認

実施方法1: ホスト側から間接的にartisanを実行する

```bash
$ docker-compose exec app php artisan route:list
```

実施方法2: appコンテナ内でartisanを実行する

```bash
$ docker-compose exec app bash
# cd creator
# php artisan route:list
```

### debug方法

Xdebug3でデバッグできる。

vscodeの場合、launch.json内に以下のように記載する。(必要な拡張は各自インストールすること)

```json
{
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for Xdebug",
            "type": "php",
            "request": "launch",
            "port": 9003,
            "pathMappings": {
                "/var/www": "${workspaceRoot}/creator"
             }
        },
    ]
}
```


## Add your files

-- [ ] [Create](https://docs.gitlab.com/ee/user/project/repository/web_editor.html#create-a-file) or [upload](https://docs.gitlab.com/ee/user/project/repository/web_editor.html#upload-a-file) files
-- [ ] [Add files using the command line](https://docs.gitlab.com/ee/gitlab-basics/add-file.html#add-a-file-using-the-command-line) or push an existing Git repository with the following command:


## コミット文の内容
    
- 短い場合

      git commit -m "修正内容"

    
- 長い場合
   
  - 修正概要
    - 修正1
    - 修正1
    - 修正1
            
      

