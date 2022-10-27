package com.example.shop.form;

import javax.validation.constraints.NotBlank;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class UserForm {
    @NotBlank
    private String name;
    private String postalCode;
    private String address;
    private String phoneNumber;
    @NotBlank
    private String email;
    @NotBlank
    private String password;
}
