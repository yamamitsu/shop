package com.example.shop.controller;

import java.util.List;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.RequestMapping;

@Controller
public class MainController {
    @Autowired
    private JdbcTemplate jdbcTemplate;

    @RequestMapping("/")
    String index(Model model) {
        String sql = "SELECT * FROM m_customers";
        List<Map<String, Object>> list = jdbcTemplate.queryForList(sql);
        String passcode = (String)list.get(0).get("passcode");
		model.addAttribute("passcode", passcode);
		return "index";
    }  
}
