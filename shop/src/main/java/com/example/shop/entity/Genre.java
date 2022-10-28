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
@Table(name = "genre")
@NoArgsConstructor
@AllArgsConstructor
public class Genre{
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id")
    private Integer id;                 /** ユーザーID */
    @Column(name = "name")
    private String name;                /** ジャンル名 */
    @Column(name = "genre_status")
    private Boolean genreStatus;        /** ジャンルステータス */
    @Column(name = "created_at")
    private LocalDateTime createdAt;    /** 作成日時 */
    @Column(name = "updated_at")
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