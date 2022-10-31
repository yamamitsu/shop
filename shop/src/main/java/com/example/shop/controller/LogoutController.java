package com.example.shop.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.ModelAttribute;

import com.example.shop.form.LoginForm;
import com.example.shop.model.LoginUser;

@Controller
public class LogoutController {
    @Autowired
    LoginUser loginUser;
    /** 「form-backing bean」の初期化 */
    @ModelAttribute
    public LoginForm setUpForm(){
        LoginForm form = new LoginForm();
        return form;
    }

    /** ログアウト処理 */
    @GetMapping("/logout")
    public String logout(Model model){
        loginUser.setName(null);
        loginUser.setIsLogin(false);
        model.addAttribute("loginUser", loginUser);
        model.addAttribute("message", "ログアウトしました。");
        return "login";
    }
}
