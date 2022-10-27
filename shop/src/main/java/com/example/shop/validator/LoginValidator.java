package com.example.shop.validator;

import org.springframework.stereotype.Component;
import org.springframework.validation.Errors;
import org.springframework.validation.Validator;

import com.example.shop.form.LoginForm;

@Component
public class LoginValidator implements Validator{

    @Override
    public boolean supports(Class<?> clazz) {
        /** 引数で渡されたFormが入力チェックの対象化論理値で返す */
        return LoginForm.class.isAssignableFrom(clazz);
    }

    @Override
    public void validate(Object target, Errors errors) {
        /** 対象のFormを取得する */
        LoginForm form = (LoginForm)target;
        /** 値が入っているかの判定 */
        if(form.getEmail().isBlank() || form.getPassword().isBlank()){
            /** エラーメッセージの設定 */
            errors.reject("com.example.shop.validator.LoginValidator.message");
        }
    }


    
}
