
-- DROP DATABASE IF EXISTS bcp_creator;
CREATE DATABASE IF NOT EXISTS bcp_creator;
USE bcp_creator;

-- --------------------------------------------------------
--
-- テーブルの構造 `m_customers`
-- BCPの書式全体を「BCP入力書式」として規定し、IDを割り当てたもの
--
-- DROP TABLE IF EXISTS `m_customers`;
CREATE TABLE `m_customers`
(
    `cid`       INT NOT NULL AUTO_INCREMENT             COMMENT '顧客ID',
    `user_id`   VARCHAR(50) NOT NULL                    COMMENT '基幹システムのユーザーID',
    `passcode`  VARCHAR(60) NOT NULL                    COMMENT '基幹システムのパスコード',
    `mode`      INT NOT NULL DEFAULT 1                  COMMENT '契約状況コード(1:契約中, 2:仮契約(有効), 10:仮契約(無効), 11:無効, 12:未入金',
    `memo`      TEXT DEFAULT NULL                       COMMENT 'メモ',
    `registered_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '最終認証成功日時',
    `expired_at` TIMESTAMP NOT NULL                     COMMENT '認証無効日時',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP    COMMENT '作成日時',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修正日時',
    PRIMARY KEY (`cid`)
)
COMMENT='事業所マスタ'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;

-- --------------------------------------------------------
--
-- テーブルの構造 `m_formula`
-- BCPの書式全体を「BCP入力書式」として規定し、IDを割り当てたもの
--
-- 有効フラグ:
--   当分は有効なBCP入力書式をシステム中ただ１個とし、残りは無効にしておく。
--   BCP登録時にはis_valid=TRUEのレコードが自動選択される
-- DROP TABLE IF EXISTS `m_formula`;
CREATE TABLE `m_formula`
(
    `formula_id` INT NOT NULL AUTO_INCREMENT          COMMENT '入力書式ID',
    `version`    INT NOT NULL DEFAULT 100             COMMENT 'バージョン数(大きいほど新しい。原則100刻み)',
    `title`      VARCHAR(50) NOT NULL                 COMMENT 'タイトル',
    `memo`       TEXT DEFAULT NULL                    COMMENT 'メモ',
    `valid_flag` BOOLEAN DEFAULT FALSE                COMMENT '有効フラグ',
    `created_on` DATE NOT NULL DEFAULT (CURRENT_DATE) COMMENT '作成日',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP  COMMENT '作成日時',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修正日時',
    PRIMARY KEY (`formula_id`)
)
COMMENT='入力書式マスタ'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;

-- --------------------------------------------------------
--
-- テーブルの構造 `m_chapters`
-- BCPは複数の章から構成される
--
-- Chapter同士で親子関係をもたせることができる
--
-- DROP TABLE IF EXISTS `m_chapters`;
CREATE TABLE `m_chapters`
(
    `chapter_id` INT NOT NULL AUTO_INCREMENT         COMMENT '章ID',
    `parent_id`  INT DEFAULT NULL                    COMMENT '親の章ID。トップレベルの場合はNULL',
    `first_id`   INT DEFAULT NULL                    COMMENT '初代の章ID。改訂版の場合に初代の章IDを指定する',
    `version`    INT NOT NULL DEFAULT 100            COMMENT 'バージョン数(大きいほど新しい。原則100刻み)',
    `title`      VARCHAR(50) NOT NULL                COMMENT 'タイトル',
    `content`    TEXT DEFAULT NULL                   COMMENT 'キャプション。章のタイトルの直後、設問の前に表示するテキスト',
    `memo`       TEXT DEFAULT NULL                   COMMENT 'メモ(画面には表示されない)',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修正日時',
    PRIMARY KEY (`chapter_id`)
)
COMMENT='章マスタ'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;

-- --------------------------------------------------------
--
-- テーブルの構造 `m_questions`
-- BCPは複数の設問から構成される
--
-- 設問の種別:
--   1:通常設問(自由入力)
--   2:単一選択(ラジオボタン選択)
--   3:複数選択(チェックボックス選択)
--   4:画像添付(避難所、ハザードマップ等)
--   11:施設復旧スケジュール
--   12:優先業務表
--   13:建物・説位の安全対策
--   14:電気、ガス、生活用水が止まった場合の対策
--
-- コントローラーの切り替え:
--   コントローラー名が入力されているレコードが存在する場合、その直前の入力欄までBcpFormControllerに担当させ、
--   その次の設問から controler欄記載の controllerに切り替える。
--   例: question_id:4, controller:'MapUploader'の場合
--       question_id=1〜3の設問は BcpFormController が担当し、
--       question_id=4 の設問は MapUploaderController が担当する。(章IDは流用する)
--
-- DROP TABLE IF EXISTS `m_questions`;
CREATE TABLE `m_questions`
(
    `question_id` INT NOT NULL AUTO_INCREMENT        COMMENT '項目ID',
    `parent_id`  INT DEFAULT NULL                    COMMENT '親の章ID。トップレベルの場合はNULL',
    `first_id`   INT DEFAULT NULL                    COMMENT '初代の項目ID。改訂版の場合に初代の項目IDを指定する',
    `version`    INT NOT NULL DEFAULT 100            COMMENT 'バージョン数(大きいほど新しい。原則100刻み)',
    `mode`       TINYINT NOT NULL DEFAULT 1          COMMENT '設問の種別(1:通常設問, 2:画像添付, 3:追加可能設問, 10以上:専用書式)',
    `controller` VARCHAR(20) DEFAULT NULL            COMMENT 'コントローラー名',
    `caption`    TEXT NOT NULL                       COMMENT '設問の表題',
    `subtext`    TEXT DEFAULT NULL                   COMMENT '設問に付属するテキスト(オプション)',
    `hint`       TEXT DEFAULT NULL                   COMMENT 'ヒント(注釈として画面上に直接的、間接的に表示される)',
    `memo`       TEXT DEFAULT NULL                   COMMENT 'メモ',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修正日時',
    PRIMARY KEY (`question_id`)
)
COMMENT='設問マスタ'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;

-- --------------------------------------------------------
--
-- テーブルの構造 `m_formula_chapters`
-- BCP入力書式内の章構造を規定する
--
-- 本来m_formula_questionsのみで章構造は表現可能だが、DISTINCTを使用する複雑なSQLが必要となるため、
-- 構造の簡易化のために設置する
--
-- DROP TABLE IF EXISTS `m_formula_chapters`;
CREATE TABLE `m_formula_chapters`
(
    `formula_id`  INT NOT NULL                    COMMENT '入力書式ID',
    `chapter_id`  INT NOT NULL                    COMMENT '章ID',
    `idx`         VARCHAR(10) NOT NULL            COMMENT '章番号(1. 1.1. 2. など',
    `priority`    SMALLINT NOT NULL               COMMENT '表示順(大きいほど優先)',
    PRIMARY KEY (`formula_id`, `chapter_id`)
)
COMMENT='ドキュメント章関連マスタ'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;

-- --------------------------------------------------------
--
-- テーブルの構造 `m_formula_questions`
-- BCP入力書式内の設問構造を規定する
--
-- BCP入力書式および設問は両テーブルに別々に定義し、BCP入力書式内の設問の並びはこのテーブルで関連付ける。
-- これによりBCP入力書式、設問を個別に更新、古いバージョンと新しいバージョンを並列して保持することを可能とする。
--
-- priority降順に並べたときに章IDごとにまとまって並ぶように表示順を設定する必要がある
--
-- DROP TABLE IF EXISTS `m_formula_questions`;
CREATE TABLE `m_formula_questions`
(
    `formula_id`       INT NOT NULL               COMMENT '入力書式ID',
    `chapter_id`       INT NOT NULL               COMMENT '章ID',
    `question_id`      INT NOT NULL               COMMENT '項目ID',
    `main_chapter_id`  INT NOT NULL               COMMENT 'メインの章ID(サブの章IDの場合、異なる値になる)',
    `priority`         SMALLINT NOT NULL          COMMENT '表示順(大きいほど優先)',
    PRIMARY KEY (`formula_id`, `chapter_id`, `question_id`)
)
COMMENT='ドキュメント設問関連マスタ'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;

-- --------------------------------------------------------
--
-- テーブルの構造 `m_branches`
-- BCPの設問は複数の入力欄から構成される
--
-- 章、および設問についてはエンドユーザーが増減することはできないが、
-- 入力欄については必要に応じてエンドユーザーが追加することができる。
-- DROP TABLE IF EXISTS `m_branches`;
CREATE TABLE `m_branches`
(
    `branch_id`       INT NOT NULL AUTO_INCREMENT    COMMENT '項目ID',
    `question_id`     INT NOT NULL                   COMMENT '項目を登録する設問ID',
    `first_branch_id` INT DEFAULT NULL               COMMENT '初代の項目ID。改訂版の場合に初代の項目IDを指定する',
    `version`         INT NOT NULL DEFAULT 100       COMMENT 'バージョン数(大きいほど新しい。原則100刻み)',
    `content`         TEXT NOT NULL                  COMMENT '本文',
    `hint`            TEXT DEFAULT NULL              COMMENT 'ヒント(注釈として画面上に直接的、間接的に表示される)',
    `memo`            TEXT DEFAULT NULL              COMMENT 'メモ',
    `priority`        SMALLINT NOT NULL DEFAULT 10   COMMENT '表示順(大きいほど優先)',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修正日時',
    PRIMARY KEY (`branch_id`)
)
COMMENT='項目マスタ'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;

-- --------------------------------------------------------
--
-- テーブルの構造 `users`
-- BCPオンラインマニュアル用のユーザーリスト
--
-- 原則として各事業者の全従業員（アルバイト等含む）分作成される
--
-- DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`
(
    `user_id`    INT NOT NULL AUTO_INCREMENT         COMMENT 'ユーザーID',
    `cid`        INT NOT NULL                        COMMENT '契約ID',
    `email`      VARCHAR(100) NOT NULL               COMMENT 'メールアドレス(ログインIDを兼ねる)',
    `passcode`   VARCHAR(60) NOT NULL                COMMENT 'ハッシュ化したパスワード',
    `name`       VARCHAR(50) NOT NULL                COMMENT 'ユーザー氏名',
    `kana`       VARCHAR(50) DEFAULT NULL            COMMENT 'ユーザー氏名(カナ表記)',
    `role`       TINYINT NOT NULL                    COMMENT '1:管理者,5:従業員',
    `memo`       TEXT DEFAULT NULL                   COMMENT 'メモ',
    `priority`   SMALLINT NOT NULL                   COMMENT '表示順(大きいほど優先)',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修正日時',
    PRIMARY KEY (`user_id`)
)
COMMENT='ユーザーテーブル'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;


-- --------------------------------------------------------
--
-- テーブルの構造 `documents`
-- BPC入力書式を用いて事業者が入力した実際のBCPドキュメント(PDF出力対象)
--
-- DROP TABLE IF EXISTS `documents`;
CREATE TABLE `documents`
(
    `document_id` INT NOT NULL AUTO_INCREMENT         COMMENT 'ドキュメントID',
    `cid`        INT NOT NULL                         COMMENT '契約ID',
    `formula_id` INT NOT NULL                         COMMENT '入力書式ID',
    `version`    INT NOT NULL DEFAULT 100             COMMENT 'バージョン数(大きいほど新しい。原則100刻み)',
    `first_id`   INT DEFAULT NULL                     COMMENT '初代の章ID。改訂版の場合に初代の章IDを指定する',
    `memo`       TEXT DEFAULT NULL                    COMMENT 'メモ',
    `created_on` DATE NOT NULL DEFAULT (CURRENT_DATE) COMMENT '作成日',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP  COMMENT '作成日時',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修正日時',
    PRIMARY KEY (`document_id`)
)
COMMENT='ドキュメントテーブル'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;

-- --------------------------------------------------------
--
-- テーブルの構造 `entries`
-- BCPオンラインの各章、各項目の入力内容
--
-- DROP TABLE IF EXISTS `entries`;
CREATE TABLE `entries`
(
    `entry_id`    INT NOT NULL AUTO_INCREMENT        COMMENT '入力内容ID',
    `cid`         INT NOT NULL                       COMMENT '契約ID',
    `document_id` INT NOT NULL                       COMMENT 'ドキュメントID',
    `chapter_id`  INT NOT NULL                       COMMENT '章ID',
    `question_id` INT DEFAULT NULL                   COMMENT '設問ID',
    `branch_id`   INT DEFAULT NULL                   COMMENT '項目ID',
    `content`     TEXT DEFAULT NULL                  COMMENT '本文',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修正日時',
    PRIMARY KEY (`entry_id`)
)
COMMENT='入力内容テーブル'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;

-- --------------------------------------------------------
--
-- テーブルの構造 `entry_images`
-- BCPオンラインの入力の添付データ（画像など）
--
-- DROP TABLE IF EXISTS `entry_images`;
CREATE TABLE `entry_images`
(
    `entry_id`   INT NOT NULL                        COMMENT '入力内容ID',
    `cid`        INT NOT NULL                        COMMENT '契約ID',
    `content`    MEDIUMBLOB NOT NULL                 COMMENT '添付データ',
    `content_path` VARCHAR(100) DEFAULT NULL         COMMENT 'ウェブサーバー上にファイルとして保存したときのファイルPATH。アクセス前に存在チェックが必須',
    `memo`       TEXT DEFAULT NULL                   COMMENT '本文',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修正日時',
    PRIMARY KEY (`entry_id`)
)
COMMENT='入力内容添付ファイルテーブル'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;
