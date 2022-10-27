INSERT INTO user (name, postal_code, address, phone_number, email, password, user_status) VALUES 
('山光良祐', '1234567', '京都府京都市', '1234567890', 'yamasuke.ry@gmail.com', 'password', 0);

INSERT INTO user (name, postal_code, address, phone_number, email, password, user_status) VALUES 
('yamamitsu', '1234567', '京都府京都市', '1234567890', 'r_yamamitsu@libertyfish.co.jp', 'password', 0);

INSERT INTO user (name, postal_code, address, phone_number, email, password, user_status) VALUES 
('山田太郎', '1111111', '大阪府大阪市', '1111111111', 'email@gmail.com', 'pass', 1);

INSERT INTO genre (name, genre_status) VALUES ('きのみ', true);

INSERT INTO genre (name, genre_status) VALUES ('ボール', false);

INSERT INTO product (genre_id, name, explanation, tax_out_price, is_sale) VALUES 
(1, 'クラボのみ', '持たせると、戦闘中に『まひ』状態になった時に自分で治す。', 100, true);

INSERT INTO product (genre_id, name, explanation, tax_out_price, is_sale) VALUES 
(1, 'カゴのみ', '持たせると、戦闘中に『ねむり』状態になった時に自分で治す。', 120, false);

INSERT INTO product (genre_id, name, explanation, tax_out_price, is_sale) VALUES 
(2, 'モンスターボール', '野生のポケモンに 投げて 捕まえるための ボール。カプセル式に なっている。', 200, true);

INSERT INTO product (genre_id, name, explanation, tax_out_price, is_sale) VALUES 
(2, 'スーパーボール', 'モンスターボールよりも さらに ポケモンを 捕まえやすくなった 少し 性能のいい ボール。', 600, false);