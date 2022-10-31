package com.example.shop.model;

import java.io.Serializable;

import org.springframework.stereotype.Component;
import org.springframework.web.context.annotation.SessionScope;

@Component
@SessionScope
public class LoginUser implements Serializable{
    private static final long serialVersionUID = 1L;
    private String name;
    private Boolean isLogin = false;
    
    public LoginUser(){}
    public LoginUser(String name, Boolean isLogin){
        this.name = name;
        this.isLogin = isLogin;
    }
    public String getName(){return name;}
    public Boolean getIsLogin(){return isLogin;}
    public void setName(String name){this.name = name;}
    public void setIsLogin(Boolean isLogin){this.isLogin = isLogin;}
}
