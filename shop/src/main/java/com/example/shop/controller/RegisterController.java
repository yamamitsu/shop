package com.example.shop.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.BindingResult;
import org.springframework.validation.annotation.Validated;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;

import com.example.shop.entity.User;
import com.example.shop.form.UserForm;
import com.example.shop.service.UserService;

@Controller
@RequestMapping("/register")
public class RegisterController {

    @Autowired
    UserService service;
    
     /** 「form-backing bean」の初期化 */
     @ModelAttribute
     public UserForm setUpForm(){
         UserForm form = new UserForm();
         return form;
     }

    @GetMapping("")
    public String showRegister(){
        return "register";
    }

    @PostMapping("/main")
    public String register(@Validated UserForm form, BindingResult bindingResult, Model model){
        if(bindingResult.hasErrors()){
            /** 入力チェックエラーの場合ログイン画面へリダイレクト */
            return "register";
        }
        User user = new User();
        user.setName(form.getName());
        user.setPostalCode(form.getPostalCode());
        user.setAddress(form.getAddress());
        user.setPhoneNumber(form.getPhoneNumber());
        user.setEmail(form.getEmail());
        user.setPassword(form.getPassword());
        boolean result = service.register(user);
        if(!result){/** 登録失敗の時 */
            model.addAttribute("caution", "このメールアドレスはすでに使用されています。");
            return "register";
        }else{
            model.addAttribute("name", user.getName());
        return "main";
        }
    }
}
