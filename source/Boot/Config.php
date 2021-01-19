<?php

/*
 * SITE Settings
 */
define("CONF_SITE_NAME", "Gerenciador de Biblioteca");
define("CONF_SITE_LANG", "pt_BR");
define("CONF_SITE_DOMAIN", "minhabiblioteca.com.br");
define("CONF_SITE_TITLE", "Gerenciador Completo para Bibliotecas");
define("CONF_SITE_DESC", "O Gerenciador de Bibliotecas da rockByte permite que alunos aluguem livros, com prazos definidos.");


/*
 * DATABASE Settings
 */
define("CONF_DB_HOST", "localhost");
define("CONF_DB_NAME", "mylibrary");
define("CONF_DB_USER", "root");
define("CONF_DB_PASS", "");

/*
 * EMAIL Settings
 */
define("CONF_MAIL_HOST", "smtp.sendgrid.net");
define("CONF_MAIL_PORT", "587");
define("CONF_MAIL_USER", "apikey");
define("CONF_MAIL_PASS", "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");
define("CONF_MAIL_SENDER", ["name" => "Gustavo Pinheiro", "address" => "rockbytebrasil@gmail.com"]);
define("CONF_MAIL_SUPPORT", "sender@support.com");
define("CONF_MAIL_OPTION_LANG", "br");
define("CONF_MAIL_OPTION_HTML", true);
define("CONF_MAIL_OPTION_AUTH", true);
define("CONF_MAIL_OPTION_SECURE","tls");
define("CONF_MAIL_OPTION_CHARSET", "utf-8");

/*
 * PASSWORD Settings
 */
define("CONF_PASSWD_MIN_LEN", 8);
define("CONF_PASSWD_MAX_LEN", 40);
define("CONF_PASSWD_ALGO", PASSWORD_DEFAULT);
define("CONF_PASSWD_OPTION", ["cost" => 10]);

/*
 * URL Settings
 */
define("CONF_URL_TEST", "https://www.localhost/mylibrary");
define("CONF_URL_BASE", "https://minhabiblioteca.com.br");

/*
 * DATE Settings
 */
define("CONF_DATE_BR", "d/m/Y H:i:s");
define("CONF_DATE_APP", "Y/m/d H:i");

/*
 * UPLOAD Settings
 */
define('CONF_UPLOAD_DIR', "storage");
define('CONF_UPLOAD_IMG_DIR', "storage/images");

/**
 * CACHE Settings
 */
define("CONF_CACHE_IMG_PATH", CONF_UPLOAD_IMG_DIR . "/cache");
define("CONF_CACHE_IMG_QUALITY", ["jpg" => 75, "png" => 5]);


/*
 * SOCIAL Settings
 */
define("CONF_SOCIAL_TWITTER_CREATOR", "@creator");
define("CONF_SOCIAL_TWITTER_PUBLISHER", "@creator");
define("CONF_SOCIAL_FB_PAGE", "pagename");
define("CONF_SOCIAL_FB_AUTHOR", "pageauthor");
define("CONF_SOCIAL_FB_APPID", "appid");


/*
 * THEME Settings
 */
define("CONF_THEME_WEB", "serviceweb");
define("CONF_THEME_APP", "serviceapp");
define("CONF_THEME_PATH_WEB", "themes/serviceweb");
define("CONF_THEME_PATH_APP", "themes/serviceapp");
define("CONF_THEME_EXT", "php");

