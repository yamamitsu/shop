
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
    `first_id`   INT DEFAULT NULL                    COMMENT '初代の項目ID。改訂版の場合に初代の項目IDを指定する',
    `version`    INT NOT NULL DEFAULT 100            COMMENT 'バージョン数(大きいほど新しい。原則100刻み)',
    `mode`       TINYINT NOT NULL DEFAULT 1          COMMENT '設問の種別(1:通常設問, 2:画像添付, 10以上:専用書式)',
    `controller` VARCHAR(20) DEFAULT NULL            COMMENT 'コントローラー名',
    `content`    TEXT NOT NULL                       COMMENT '本文',
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
    `formula_id`  INT NOT NULL                    COMMENT '入力書式ID',
    `chapter_id`  INT NOT NULL                    COMMENT '章ID',
    `question_id` INT NOT NULL                    COMMENT '項目ID',
    `priority`    SMALLINT NOT NULL               COMMENT '表示順(大きいほど優先)',
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
    `memo`       TEXT DEFAULT NULL                   COMMENT '本文',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修正日時',
    PRIMARY KEY (`entry_id`)
)
COMMENT='入力内容添付ファイルテーブル'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;

INSERT INTO m_customers (cid, user_id, passcode, memo, expired_at) VALUES 
(1, 'test', '$2y$10$wGcM7TMgHZ9Cr0jPpioTIOGAqFfUniRKQAT45vUbXwx.0fwi1c9dy', 'テストユーザー', DATE_ADD(CURRENT_TIMESTAMP, INTERVAL 1 YEAR));

INSERT INTO m_formula (formula_id, title, memo, valid_flag) VALUES 
(1, 'BCP入力書式2020年10月版', 'テスト用入力書式', 1);

INSERT INTO m_chapters (chapter_id, parent_id, title) VALUES 
(1, NULL, '総論')
,(2, 1, '基本方針')
,(3, 1, '全体像')
,(4, 1, '推進体制')
,(5, 1, 'リスクの把握')
,(6, 1, '優先業務の選定')
,(7, NULL, '研修・訓練の実施、ＢＣＰの検証・見直し')
,(8, NULL, '平常時の対応')
,(56, NULL, 'ハザードマップ')
;


INSERT INTO m_questions (question_id, content) VALUES 
(1, 'BCPの総論を記入します。(1)')
,(2, '基本方針を記入します。(2)')
,(3, '全体像')
,(4, '推進体制')
,(5, 'リスクの把握')
,(6, '優先業務の選定')
;
INSERT INTO m_questions (question_id, controller, content) VALUES 
(151, 'MapUpload', '地震')
,(152, 'MapUpload', '津波')
,(153, 'MapUpload', '液状化')
,(154, 'MapUpload', '土砂崩れ')
,(155, 'MapUpload', '水害(洪水)')
,(156, 'MapUpload', '高潮、溜池等')
;

INSERT INTO m_branches (branch_id, question_id, priority, content, hint) VALUES 
(1, 1, 10, '地震のみならず、大型台風、集中豪雨、大雪による被害など多くの災害を経験し、近年の我が国は常に自然災害と隣り合わせの状況にあります。地球温暖化による影響も考えられ、事前の予測も難しく、今後も自然災害の発生リスクは一層高まっていっても過言ではありません。

 そのような中、福祉用具関連サービスは、要介護者、その家族等の生活を支える上で欠かせないものであり、もし突発的な経営環境の変化など不測の事態が発生しても、被害を最小限に食い止め、その後も利用者に必要なサービスを継続的に提供できる体制を構築し備えておくことが重要です。必要な時に必要な福祉用具を必要とされている方に適切な対応と適切に供給できるように、平時から重要な事業を中断させない、あるいは中断しても可能な限り短い期間で復旧させ優先業務を実施できるための方針、体制、手順等を示した計画をあらかじめ検討して準備や訓練をしておくことが重要です。', NULL)
,(2, 2, 40, '福祉用具のご利用や住環境整備の対象の方々は、重症化リスクが高く、災害発生時に深刻な人的被害が生じるおそれがあることに留意し、「利用者の安全を守るための対策およびその確保」が何よりも重要となります。', '①ご利用者の安全確保')
,(3, 2, 30, '従業員の生命を守り、生活の維持に努める。 自然災害発生時や復旧において業務継続を図ることは、長時間勤務や精神的打撃など従業員の労働環境が過酷にあることが懸念されます。したがって、従業員の過重労働やメンタルヘルス対応への適切な措置を講じることが使用者の責務となります。', '②従業員の安全確保')
,(4, 2, 20, 'ご利用者の生命、身体の安全、健康、生活を守るために最低限必要となるサービス機能を維持する。    （重要な事業を中断させない、または中断しても可能な限り短い時間で復旧させる。）', '③サービスの継続')
,(5, 2, 10, '介護事業者の社会福祉活動の公共性を鑑みると、無事であることを前提に、事業者がもつ機能を活かして被災時に地域へ貢献することも重要な役割となります。', '④地域への貢献')
,(6, 3, 10, '【ポイント】
１．総論、２．平常時の対応、３．緊急時の対応、４．他施設との連携、５．地域との連携の順に検討する。', '自然災害(地震・水害等)BCPのフローチャート')
,(7, 4, 20, '災害対策は一過性のものではなく、日頃から継続して取り組む必要がある。また災害対策の推進には、総務部などの一部門で進めるのではなく、多くの部門が関与することが効果的である。
【様式１】推進体制の構成メンバーに体制を記入する。', '●継続的かつ効果的に取組みを進めるために推進体制を構築する。')
,(8, 4, 10, 'ここでは平常時における災害対策や事業継続の検討・策定や各種取組を推進する体制を記載する。', '被災した場合の対応体制は「３．緊急時の対応」の項目に記載する。')
;

INSERT INTO m_formula_chapters (formula_id, chapter_id, idx, priority) VALUES 
(1, 1, '1.', 90)
,(1, 2, '1.1', 80)
,(1, 3, '1.2', 70)
,(1, 7, '2.', 20)
,(1, 8, '3.', 10)
,(1, 56, '補足6', 5)
;
INSERT INTO m_formula_questions (formula_id, chapter_id, question_id, priority) VALUES 
(1, 1, 1, 90)
,(1, 1, 2, 80)
,(1, 1, 3, 70)
,(1, 1, 4, 60)
,(1, 1, 5, 50)
,(1, 1, 6, 40)
;
INSERT INTO m_formula_questions (formula_id, chapter_id, question_id, priority) VALUES 
(1, 56, 1, 9)
,(1, 56, 2, 8)
,(1, 56, 3, 7)
,(1, 56, 4, 6)
,(1, 56, 5, 5)
,(1, 56, 6, 4)
;