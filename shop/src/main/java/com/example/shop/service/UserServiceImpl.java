package com.example.shop.service;

import java.util.List;
import java.util.Optional;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import com.example.shop.entity.User;
import com.example.shop.repository.UserRepository;

@Service
@Transactional
public class UserServiceImpl implements UserService{

    @Autowired
    UserRepository repository;

    /** ログイン処理 */
    @Override
    public List<User> doLogin(String email, String password) {
        List<User> userList = repository.findByEmailAndPassword(email,password);
        return userList;
    }

    /** 登録処理 */
    public boolean register(User user){
        if(repository.findByEmail(user.getEmail()).isPresent()){
            return false;
        }
        repository.save(user);
        return true;
    }

    @Override
    public Optional<User> findByEmail(String email) {
        return repository.findByEmail(email);
    }
}
