package com.example.shop.entity;

import java.time.LocalDateTime;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Table;

import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedDate;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Entity
@Data
@Table(name = "user")
@NoArgsConstructor
@AllArgsConstructor
public class User {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id")
    private Integer id;                 /** ユーザーID */
    @Column(name = "name")
    private String name;                /** ユーザー名 */
    @Column(name = "postal_code")
    private String postalCode;          /** 郵便番号 */
    @Column(name = "address")
    private String address;             /** 住所 */
    @Column(name = "phone_number")
    private String phoneNumber;         /** 電話番号 */
    @Column(name = "email")
    private String email;               /** メールアドレス */
    @Column(name = "password")
    private String password;            /** パスワード */
    @Column(name = "created_ad")
    private LocalDateTime createdAt;    /** 作成日時 */
    @Column(name = "updated_ad")
    private LocalDateTime updatedAt;    /** 更新日時 */

    @CreatedDate
    @Column(name = "created_at", updatable = true)
    public LocalDateTime getCreatedAt() {
        return createdAt;
    }

    @LastModifiedDate
    @Column(name = "updated_at")
    public LocalDateTime getUpdatedAt() {
        return updatedAt;
    }

}
