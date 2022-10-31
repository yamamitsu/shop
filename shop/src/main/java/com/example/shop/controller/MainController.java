package com.example.shop.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;

import com.example.shop.model.LoginUser;
import com.example.shop.service.ProductService;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;

@Controller
@RequestMapping("/main")
public class MainController {
    @Autowired
    ProductService service;
    @Autowired
    LoginUser loginUser;

    @GetMapping
    public String show(Model model) {
        if(loginUser.getIsLogin() != true){
            model.addAttribute("caution", "認証が必要です、ログインしてください。");
            return "login";
        }
        model.addAttribute("loginUser", loginUser);
        model.addAttribute("productList", service.findAll());
        return "main";
    }
    
}
