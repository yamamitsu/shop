package com.example.shop;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;

// @Controller
@SpringBootApplication
public class ShopApplication {

	// @Autowired
    // private JdbcTemplate jdbcTemplate;

    // @RequestMapping("/")
    // String hello(Model model) {
    //     String sql = "SELECT * FROM m_customers";
    //     List<Map<String, Object>> list = jdbcTemplate.queryForList(sql);
    //     String passcode = (String)list.get(0).get("passcode");
	// 	model.addAttribute("passcode", passcode);
	// 	return "index";
    // }  
    
	public static void main(String[] args) {
		SpringApplication.run(ShopApplication.class, args);
	}

}



