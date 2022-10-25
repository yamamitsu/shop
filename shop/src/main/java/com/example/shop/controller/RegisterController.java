package com.example.shop.controller;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;

@Controller
public class RegisterController {
    
    @GetMapping("/register")
    public String showRegister(){
        return "register";
    }

    @GetMapping("/register/main")
    public String register(){
        return "redirect:..";
    }
}
