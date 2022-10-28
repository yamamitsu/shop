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
import javax.persistence.OneToMany;
import javax.persistence.Table;

import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedDate;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Entity
@Data
@Table(name = "cart")
@NoArgsConstructor
@AllArgsConstructor
public class Cart {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id")
    private Integer id;                 /** カートID */
    @Column(name = "producted_id")
    private Integer productId;          /** 商品ID */
    @Column(name = "user_id")
    private Integer userId;             /** ユーザーID */
    @Column(name = "quantity")
    private Integer quantitiy;          /** 商品購入個数 */
    @Column(name = "created_at")
    private LocalDateTime createdAt;    /** 作成日時 */
    @Column(name = "updated_at")
    private LocalDateTime updatedAt;    /** 更新日時 */

    @OneToMany(targetEntity = Product.class)
    @JoinColumn(name = "product_id", referencedColumnName = "id", 
    insertable = false, updatable = false)
    private List<Product> products = new ArrayList<Product>();

    @OneToMany(targetEntity = User.class)
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
