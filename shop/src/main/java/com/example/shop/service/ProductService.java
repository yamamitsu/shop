package com.example.shop.service;

import java.util.List;

import com.example.shop.entity.Product;

public interface ProductService {
    /** 全件検索 */
    List<Product> findAll();
}
