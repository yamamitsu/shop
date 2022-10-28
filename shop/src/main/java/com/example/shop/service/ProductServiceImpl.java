package com.example.shop.service;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import com.example.shop.entity.Product;
import com.example.shop.repository.ProductRepository;

@Service
@Transactional
public class ProductServiceImpl implements ProductService{
    @Autowired
    ProductRepository repository;

    @Override
    public List<Product> findAll() {    
        return repository.findAll();
    }
    
}
