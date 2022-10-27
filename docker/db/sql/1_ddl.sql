
-- DROP DATABASE IF EXISTS bcp_creator;
CREATE DATABASE IF NOT EXISTS bcp_creator;
USE bcp_creator;

-- --------------------------------------------------------
--
-- テーブルの構造 `user`
-- 
--
-- DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`
(
    `id`   INT NOT NULL AUTO_INCREMENT                  COMMENT 'ユーザーID',
    `name`      VARCHAR(30) NOT NULL                    COMMENT 'ユーザー名',
    `postal_code` VARCHAR(255) NOT NULL                 COMMENT '郵便番号',
    `address`   VARCHAR(255) NOT NULL                   COMMENT '住所',
    `phone_number` VARCHAR(255)                         COMMENT '電話番号',
    `email`     VARCHAR(255) NOT NULL UNIQUE            COMMENT 'メールアドレス',
    `password`  VARCHAR(60) NOT NULL                    COMMENT 'パスワード',
    `user_status` INT NOT NULL DEFAULT 1                COMMENT 'ユーザー状態(0:管理者, 1:ユーザー, 9:無効)',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP    COMMENT '作成日時',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    PRIMARY KEY (`id`)
)
COMMENT='ユーザーマスタ'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;

-- --------------------------------------------------------
--
-- テーブルの構造 `shipping_address`
-- 
-- DROP TABLE IF EXISTS `shipping_address`;
CREATE TABLE `shipping_address`
(
    `id` INT NOT NULL AUTO_INCREMENT                        COMMENT '配送先ID',
    `user_id`       INT NOT NULL                            COMMENT 'ユーザーID',
    `name`          VARCHAR(50) NOT NULL                    COMMENT '宛名',
    `postal_code`   VARCHAR(255) NOT NULL                   COMMENT '配送先郵便番号',
    `address`       VARCHAR(255) NOT NULL                   COMMENT '配送先住所',
    `created_at`    TIMESTAMP DEFAULT CURRENT_TIMESTAMP     COMMENT '登録日時',
    `updated_at`    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES user(`id`)
)
COMMENT='配送先マスタ'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;

-- --------------------------------------------------------
--
-- テーブルの構造 `order`
--
-- DROP TABLE IF EXISTS `order`;
CREATE TABLE `order`
(
    `id`      INT NOT NULL AUTO_INCREMENT                   COMMENT '注文ID',
    `user_id`       INT NOT NULL                            COMMENT 'ユーザーID',
    `name`          VARCHAR(50) NOT NULL                    COMMENT '宛名',
    `postal_code`   VARCHAR(255) NOT NULL                   COMMENT '配送先郵便番号',
    `address`       VARCHAR(255) NOT NULL                   COMMENT '配送先住所',
    `postage`       INT DEFAULT 800                         COMMENT '送料',
    `total_price`   INT                                     COMMENT '請求額',
    `payment_method` INT DEFAULT 0                          COMMENT '支払方法',
    `order_status`  INT DEFAULT 0                           COMMENT '注文ステータス',
    `created_at`    TIMESTAMP DEFAULT CURRENT_TIMESTAMP     COMMENT '登録日時',
    `updated_at`    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES user(`id`)
)
COMMENT='注文マスタ'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;

-- --------------------------------------------------------
--
-- テーブルの構造 `genre`
--
-- DROP TABLE IF EXISTS `genre`;
CREATE TABLE `genre`
(
    `id`            INT NOT NULL AUTO_INCREMENT             COMMENT 'ジャンルID',
    `name`          VARCHAR(255)                            COMMENT 'ジャンル名',
    `genre_status`  BOOLEAN DEFAULT false                   COMMENT 'ジャンルステータス',
    `created_at`    TIMESTAMP DEFAULT CURRENT_TIMESTAMP     COMMENT '登録日時',
    `updated_at`    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    PRIMARY KEY (`id`)
)
COMMENT='ジャンルマスタ'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;

-- --------------------------------------------------------
--
-- テーブルの構造 `product`
--
-- DROP TABLE IF EXISTS `product`;
CREATE TABLE `product`
(
    `id`            INT NOT NULL AUTO_INCREMENT            	COMMENT '商品ID',
    `genre_id`      INT NOT NULL                           	COMMENT 'ジャンルID',
    `name`          VARCHAR(255) NOT NULL                  	COMMENT '商品名',
    `explanation`   VARCHAR(255)                               	COMMENT '商品説明',
    `tax_out_price` INT NOT NULL                           	COMMENT '税抜価格',
    `is_sale`       BOOLEAN NOT NULL DEFAULT false          COMMENT '販売ステータス(true:販売可, false:販売不可)',
    `created_at`    TIMESTAMP DEFAULT CURRENT_TIMESTAMP     COMMENT '登録日時',
    `updated_at`    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    PRIMARY KEY (`id`),
    FOREIGN KEY (`genre_id`) REFERENCES genre(`id`)
)
COMMENT='商品マスタ'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;

-- --------------------------------------------------------
--
-- テーブルの構造 `order_detail`
--
-- DROP TABLE IF EXISTS `order_detail`;
CREATE TABLE `order_detail`
(
    `id` INT NOT NULL AUTO_INCREMENT                        COMMENT '注文明細ID',
    `product_id`    INT NOT NULL                            COMMENT '商品ID',
    `order_id`      INT NOT NULL                            COMMENT '注文ID',
    `quantity`      INT                                     COMMENT '商品購入個数',
    `subprice`      INT                                     COMMENT '購入時価格(税込み)',
    `production_status` INT NOT NULL DEFAULT 0              COMMENT '制作ステータス',
    `created_at`    TIMESTAMP DEFAULT CURRENT_TIMESTAMP     COMMENT '登録日時',
    `updated_at`    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    PRIMARY KEY (`id`),
    FOREIGN KEY (`product_id`) REFERENCES product(`id`),
    FOREIGN KEY (`order_id`) REFERENCES `order`(`id`)
)
COMMENT='注文明細マスタ'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;

-- --------------------------------------------------------
--
-- テーブルの構造 `cart`
--
-- DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart`
(
    `id`       INT NOT NULL AUTO_INCREMENT                  COMMENT 'カートID',
    `product_id`    INT NOT NULL                            COMMENT '商品ID',
    `user_id`       INT NOT NULL                            COMMENT 'ユーザーID',
    `quantity`      INT                                     COMMENT '商品購入個数',
    `created_at`    TIMESTAMP DEFAULT CURRENT_TIMESTAMP     COMMENT '登録日時',
    `updated_at`    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時',
    PRIMARY KEY (`id`),
    FOREIGN KEY (`product_id`) REFERENCES product(`id`),
    FOREIGN KEY (`user_id`) REFERENCES user(`id`)
)
COMMENT='カートマスタ'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
ROW_FORMAT=DEFAULT;
