
-- DROP DATABASE IF EXISTS bcp_creator;
CREATE DATABASE IF NOT EXISTS bcp_creator;
USE bcp_creator;

-- --------------------------------------------------------
--
-- テーブルの構造 `M_Customers`
-- BCPの書式全体を「BCP入力書式」として規定し、IDを割り当てたもの
--
-- DROP TABLE IF EXISTS `M_Customers`;
CREATE TABLE `M_Customers`
(
    `cid`       INT NOT NULL AUTO_INCREMENT   COMMENT '顧客ID',
    `userId`    VARCHAR(50) NOT NULL          COMMENT '基幹システムのユーザーID',
    `passcode`  VARCHAR(50) NOT NULL          COMMENT '基幹システムのパスコード',
    `mode`      INT NOT NULL DEFAULT 1        COMMENT '契約状況コード(1:契約中, 2:仮契約(有効), 10:仮契約(無効), 11:無効, 12:未入金',
    `memo`      TEXT DEFAULT NULL             COMMENT 'メモ',
    `registerd` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '最終認証成功日時',
    `expired` TIMESTAMP NOT NULL COMMENT '認証無効日時',
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    `updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修正日時',
    PRIMARY KEY (`cid`)
)
COMMENT='事業所マスタ'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;

-- --------------------------------------------------------
--
-- テーブルの構造 `M_Formula`
-- BCPの書式全体を「BCP入力書式」として規定し、IDを割り当てたもの
--
-- DROP TABLE IF EXISTS `M_Formula`;
CREATE TABLE `M_Formula`
(
    `formulaId`   INT NOT NULL AUTO_INCREMENT          COMMENT '入力書式ID',
    `version`     INT NOT NULL DEFAULT 100             COMMENT 'バージョン数(大きいほど新しい。原則100刻み)',
    `title`       VARCHAR(50) NOT NULL                 COMMENT 'タイトル',
    `memo`        TEXT DEFAULT NULL                    COMMENT 'メモ',
    `createdDate` DATE NOT NULL DEFAULT (CURRENT_DATE) COMMENT '作成日',
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP      COMMENT '作成日時',
    `updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修正日時',
    PRIMARY KEY (`formulaId`)
)
COMMENT='入力書式マスタ'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;

-- --------------------------------------------------------
--
-- テーブルの構造 `M_Chapters`
-- BCPは複数の章から構成される
--
-- Chapter同士で親子関係をもたせることができる
--
-- DROP TABLE IF EXISTS `M_Chapters`;
CREATE TABLE `M_Chapters`
(
    `chapterId`   INT NOT NULL AUTO_INCREMENT     COMMENT '章ID',
    `parentId`    INT DEFAULT NULL                COMMENT '親の章ID。トップレベルの場合はNULL',
    `firstId`     INT DEFAULT NULL                COMMENT '初代の章ID。改訂版の場合に初代の章IDを指定する',
    `version`     INT NOT NULL DEFAULT 100        COMMENT 'バージョン数(大きいほど新しい。原則100刻み)',
    `title`       VARCHAR(50) NOT NULL            COMMENT 'タイトル',
    `content`     TEXT DEFAULT NULL               COMMENT 'キャプション。章のタイトルの直後、設問の前に表示するテキスト',
    `memo`        TEXT DEFAULT NULL               COMMENT 'メモ(画面には表示されない)',
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    `updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修正日時',
    PRIMARY KEY (`chapterId`)
)
COMMENT='章マスタ'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;

-- --------------------------------------------------------
--
-- テーブルの構造 `M_Questions`
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
-- DROP TABLE IF EXISTS `M_Questions`;
CREATE TABLE `M_Questions`
(
    `questionId`  INT NOT NULL AUTO_INCREMENT     COMMENT '項目ID',
    `firstId`     INT DEFAULT NULL                COMMENT '初代の項目ID。改訂版の場合に初代の項目IDを指定する',
    `version`     INT NOT NULL DEFAULT 100        COMMENT 'バージョン数(大きいほど新しい。原則100刻み)',
    `mode`        TINYINT NOT NULL DEFAULT 1      COMMENT '設問の種別(1:通常設問, 2:画像添付, 10以上:専用書式)',
    `content`     TEXT NOT NULL                   COMMENT '本文',
    `hint`        TEXT DEFAULT NULL               COMMENT 'ヒント(注釈として画面上に直接的、間接的に表示される)',
    `memo`        TEXT DEFAULT NULL               COMMENT 'メモ',
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    `updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修正日時',
    PRIMARY KEY (`questionId`)
)
COMMENT='設問マスタ'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;


-- --------------------------------------------------------
--
-- テーブルの構造 `M_FormulaQuestions`
-- BCP入力書式内の設問構造を規定する
--
-- BCP入力書式および設問は両テーブルに別々に定義し、BCP入力書式内の設問の並びはこのテーブルで関連付ける。
-- これによりBCP入力書式、設問を個別に更新、古いバージョンと新しいバージョンを並列して保持することを可能とする。
--
-- priority降順に並べたときに章IDごとにまとまって並ぶように表示順を設定する必要がある
--
-- DROP TABLE IF EXISTS `M_FormulaQuestions`;
CREATE TABLE `M_FormulaQuestions`
(
    `formulaId`   INT NOT NULL                    COMMENT '入力書式ID',
    `chapterId`   INT NOT NULL                    COMMENT '章ID',
    `questionId`  INT NOT NULL                    COMMENT '項目ID',
    `priority`    SMALLINT NOT NULL               COMMENT '表示順(大きいほど優先)',
    PRIMARY KEY (`formulaId`, `chapterId`, `questionId`)
)
COMMENT='ドキュメント設問関連マスタ'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;

-- --------------------------------------------------------
--
-- テーブルの構造 `M_Branches`
-- BCPの設問は複数の入力欄から構成される
--
-- DROP TABLE IF EXISTS `M_Branches`;
CREATE TABLE `M_Branches`
(
    `branchId`      INT NOT NULL AUTO_INCREMENT     COMMENT '項目ID',
    `questionId`    INT NOT NULL                    COMMENT '項目を登録する設問ID',
    `firstBranchId` INT DEFAULT NULL                COMMENT '初代の項目ID。改訂版の場合に初代の項目IDを指定する',
    `version`       INT NOT NULL DEFAULT 100        COMMENT 'バージョン数(大きいほど新しい。原則100刻み)',
    `content`       TEXT NOT NULL                   COMMENT '本文',
    `hint`          TEXT DEFAULT NULL               COMMENT 'ヒント(注釈として画面上に直接的、間接的に表示される)',
    `memo`          TEXT DEFAULT NULL               COMMENT 'メモ',
    `priority`      SMALLINT NOT NULL               COMMENT '表示順(大きいほど優先)',
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    `updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修正日時',
    PRIMARY KEY (`branchId`)
)
COMMENT='項目マスタ'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;

-- --------------------------------------------------------
--
-- テーブルの構造 `Users`
-- BCPオンラインマニュアル用のユーザーリスト
--
-- 原則として各事業者の全従業員（アルバイト等含む）分作成される
--
-- DROP TABLE IF EXISTS `Users`;
CREATE TABLE `Users`
(
    `userId`        INT NOT NULL AUTO_INCREMENT   COMMENT 'ユーザーID',
    `cid`           INT NOT NULL                  COMMENT '契約ID',
    `email`         VARCHAR(100) NOT NULL         COMMENT 'メールアドレス(ログインIDを兼ねる)',
    `passcode`      VARCHAR(60) NOT NULL          COMMENT 'ハッシュ化したパスワード',
    `name`          VARCHAR(50) NOT NULL          COMMENT 'ユーザー氏名',
    `kana`          VARCHAR(50) DEFAULT NULL      COMMENT 'ユーザー氏名(カナ表記)',
    `role`          TINYINT NOT NULL              COMMENT '1:管理者,5:従業員',
    `memo`          TEXT DEFAULT NULL             COMMENT 'メモ',
    `priority`      SMALLINT NOT NULL             COMMENT '表示順(大きいほど優先)',
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    `updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修正日時',
    PRIMARY KEY (`userId`)
)
COMMENT='ユーザーテーブル'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;


-- --------------------------------------------------------
--
-- テーブルの構造 `Documents`
-- BPC入力書式を用いて事業者が入力した実際のBCPドキュメント(PDF出力対象)
--
-- DROP TABLE IF EXISTS `Documents`;
CREATE TABLE `Documents`
(
    `documentId`  INT NOT NULL AUTO_INCREMENT          COMMENT 'ドキュメントID',
    `cid`         INT NOT NULL                         COMMENT '契約ID',
    `formulaId`   INT NOT NULL                         COMMENT '入力書式ID',
    `version`     INT NOT NULL DEFAULT 100             COMMENT 'バージョン数(大きいほど新しい。原則100刻み)',
    `firstId`     INT DEFAULT NULL                     COMMENT '初代の章ID。改訂版の場合に初代の章IDを指定する',
    `memo`        TEXT DEFAULT NULL                    COMMENT 'メモ',
    `createdDate` DATE NOT NULL DEFAULT (CURRENT_DATE) COMMENT '作成日',
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP      COMMENT '作成日時',
    `updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修正日時',
    PRIMARY KEY (`documentId`)
)
COMMENT='ドキュメントテーブル'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;

-- --------------------------------------------------------
--
-- テーブルの構造 `Entries`
-- BCPオンラインの各章、各項目の入力内容
--
-- DROP TABLE IF EXISTS `Entries`;
CREATE TABLE `Entries`
(
    `entryId`     INT NOT NULL AUTO_INCREMENT     COMMENT 'ユーザーID',
    `cid`         INT NOT NULL                    COMMENT '契約ID',
    `documentId`  INT NOT NULL                    COMMENT 'ドキュメントID',
    `chapterId`   INT NOT NULL                    COMMENT '章ID',
    `questionId`  INT NOT NULL                    COMMENT '設問ID',
    `branchId`    INT DEFAULT NULL                COMMENT '項目ID',
    `content`     TEXT NOT NULL                   COMMENT '本文',
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    `updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修正日時',
    PRIMARY KEY (`entryId`)
)
COMMENT='入力内容テーブル'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;

-- --------------------------------------------------------
--
-- テーブルの構造 `EntryImages`
-- BCPオンラインの入力の添付データ（画像など）
--
-- DROP TABLE IF EXISTS `EntryImages`;
CREATE TABLE `EntryImages`
(
    `entryId`     INT NOT NULL                    COMMENT 'ユーザーID',
    `cid`         INT NOT NULL                    COMMENT '契約ID',
    `content`     BLOB NOT NULL                   COMMENT '添付データ',
    `memo`        TEXT DEFAULT NULL               COMMENT '本文',
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    `updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修正日時',
    PRIMARY KEY (`entryId`)
)
COMMENT='入力内容添付ファイルテーブル'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;