<?php
define("HOST", "localhost");
define("USER", "root");
define("PASS", 15827398906);
define("PORT", 6379);
define("DB_NAME", "newsdb");
define("DB_CHARSET", "utf8");
define("ROLE_TYPE_SUPER", 4);
define("ROLE_TYPE_ADMIN", 3);
define("ROLE_TYPE_EDITOR", 2);
define("ROLE_TYPE_VISITOR", 1);
define("SECONDS_PER_HOUR", 3600);
define("SECONDS_PER_MINUTE", 60);
define("SURVIVAL_TIME_OF_NEWS", 86400);//文章缓存有效期
define("PAGE_SIZE", 6);
define("SURVIVAL_TIME_OF_WEATHER", 1800);//天气缓存有效期
define("WEATHER_DEFAULT_CITY", 101200101);//101200101为武汉编号
define("RATE_LIMITING_ARR", array('10' => 10, '100' => 60, '1000' => 3600));//缓存访问频率限制设置数组
define("LOCAL_IP",'127.0.0.1');
define("REDIS_DEFAULT_DB",1);