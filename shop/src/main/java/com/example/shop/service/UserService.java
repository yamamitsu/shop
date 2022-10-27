package com.example.shop.service;

import java.util.List;
import java.util.Optional;

import com.example.shop.entity.User;

public interface UserService{

    /** ログイン処理 */
    List<User> doLogin(String email,String password);
    /** 登録処理 */
    boolean register(User user);

    Optional<User> findByEmail(String email);
}
