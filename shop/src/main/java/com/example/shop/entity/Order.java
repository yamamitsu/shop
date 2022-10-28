package com.example.shop.entity;

import java.time.LocalDateTime;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.JoinColumn;
import javax.persistence.ManyToOne;
import javax.persistence.Table;

import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedDate;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Entity
@Data
@Table(name = "order")
@NoArgsConstructor
@AllArgsConstructor
public class Order{
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;                 /** 注文ID */
    private Integer userId;             /** ユーザーID */
    private String name;                /** 宛名 */
    private String postalCode;          /** 配送先郵便番号 */
    private String address;             /** 配送先住所 */
    private Integer postage;            /** 送料 */
    private Integer totalPrice;         /** 請求額 */
    private Integer paymentMethod;      /** 支払方法 */
    private Integer orderStatus;        /** 注文ステータス */
    private LocalDateTime createdAt;    /** 作成日時 */
    private LocalDateTime updatedAt;    /** 更新日時 */

    @ManyToOne(targetEntity = User.class)
    @JoinColumn(name = "user_id", referencedColumnName = "id")
    private User user;

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
