package com.example.shop.controller;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.BindingResult;
import org.springframework.validation.annotation.Validated;
import org.springframework.web.bind.WebDataBinder;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.InitBinder;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import com.example.shop.entity.User;
import com.example.shop.form.LoginForm;
import com.example.shop.model.LoginUser;
import com.example.shop.service.UserService;
import com.example.shop.validator.LoginValidator;

@Controller
public class LoginController {
    /** DI */
    @Autowired
    UserService service;
    @Autowired
    LoginValidator loginValidator;
    @Autowired
    LoginUser loginUser;

    /** 「form-backing bean」の初期化 */
    @ModelAttribute
    public LoginForm setUpForm(){
        LoginForm form = new LoginForm();
        return form;
    }

    /** 相関チェックの登録 */
    @InitBinder
    public void InitBinder(WebDataBinder webDataBinder){
        webDataBinder.addValidators(loginValidator);
    }

    /** ログイン画面への遷移 */
    @GetMapping("/")
    public String showLogin(Model model){
        if(loginUser.getIsLogin()){
            model.addAttribute("loginUser", loginUser);
            return "redirect:/main";
        }
        return "login";
    }

    /** ログイン処理 */
    @PostMapping("/login")
    public String login(@Validated LoginForm form, BindingResult result, Model model, 
        RedirectAttributes redirectAttributes){
        /** 入力チェック */
        if(result.hasErrors()){
            /** 入力チェックエラーの場合ログイン画面へリダイレクト */
            return "login";
        }
        String email = form.getEmail();
        String password = form.getPassword();
        List<User> userList = service.doLogin(email, password);
        if(userList.isEmpty()){/** ユーザー情報に誤りがある場合 */
            /** ログイン画面へリダイレクト */ 
            redirectAttributes.addFlashAttribute("caution", "メールアドレスまたはパスワードが誤っています。");
            return "redirect:";
        }
        String name = userList.get(0).getName();
        loginUser.setName(name);
        loginUser.setIsLogin(true);
        model.addAttribute("loginUser", loginUser);
        return "redirect:/main";
    }

}
