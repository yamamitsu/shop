package com.example.shop.entity;

import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.List;

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
    @Column(name = "id")
    private Integer id;                 /** 注文ID */
    // @Column(name = "user_id")
    // private Integer userId;             /** ユーザーID */
    // @Column(name = "name")
    private String name;                /** 宛名 */
    @Column(name = "postal_code")
    private String postalCode;          /** 配送先郵便番号 */
    @Column(name = "address")
    private String address;             /** 配送先住所 */
    @Column(name = "postage")
    private Integer postage;            /** 送料 */
    @Column(name = "total_price")
    private Integer totalPrice;         /** 請求額 */
    @Column(name = "payment_method")
    private Integer paymentMethod;      /** 支払方法 */
    @Column(name = "order_status")
    private Integer orderStatus;        /** 注文ステータス */
    @Column(name = "created_at")
    private LocalDateTime createdAt;    /** 作成日時 */
    @Column(name = "updated_at")
    private LocalDateTime updatedAt;    /** 更新日時 */

    @ManyToOne(targetEntity = User.class)
    @JoinColumn(name = "user_id", referencedColumnName = "id", 
    insertable = false, updatable = false)
    private List<User> users = new ArrayList<User>();

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
