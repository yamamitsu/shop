package com.example.shop.controller;

import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;

@Controller
public class LoginController {
    
    /** ログイン画面への遷移 */
    @GetMapping("/")
    public String showLogin(){
        return "login";
    }

    /** ログイン処理 */
    @PostMapping("/main")
    public String login(Model model){
        return "main";
    }

}
