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
@Table(name="product")
@NoArgsConstructor
@AllArgsConstructor
public class Product {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id")
    private Integer id;                 /** 商品ID */
    @Column(name = "genre_id")
    private Integer genreId;            /** ジャンルID */
    @Column(name = "name")
    private String name;                /** 商品名 */
    @Column(name = "explanation")
    private String explanation;         /** 商品説明 */
    @Column(name = "tax_out_price")
    private Integer taxOutPrice;        /** 税抜価格 */
    @Column(name = "is_sale")
    private Boolean isSale;             /** 販売状況(true:販売可, false:販売不可) */
    @Column(name = "created_at")
    private LocalDateTime createdAt;    /** 作成日時 */
    @Column(name = "updated_at")
    private LocalDateTime updatedAt;    /** 更新日時 */

    @ManyToOne(targetEntity = Genre.class)
    @JoinColumn(name="genre_id", referencedColumnName ="id", 
    insertable = false, updatable = false)
    private List<Genre> genres = new ArrayList<Genre>();

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
