package com.example.shop.model;

import java.io.Serializable;

import org.springframework.stereotype.Component;
import org.springframework.web.context.annotation.SessionScope;

@Component
@SessionScope
public class LoginUser implements Serializable{
    private static final long serialVersionUID = 1L;
    private String name;
    
    public LoginUser(){}
    public LoginUser(String name){
        this.name = name;
    }
    public String getName(){return name;}
    public void setName(String name){this.name = name;}
}
