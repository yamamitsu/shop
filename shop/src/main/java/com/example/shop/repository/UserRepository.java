package com.example.shop.repository;

import java.util.List;
import java.util.Optional;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import com.example.shop.entity.User;

@Repository
public interface UserRepository extends JpaRepository<User, String>{

    List<User> findByEmailAndPassword(String email, String password);
    Optional<User> findByEmail(String email);
}
