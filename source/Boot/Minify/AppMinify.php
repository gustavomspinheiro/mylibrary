<?php

require __DIR__."/../../../vendor/autoload.php";

if(strpos(url(), "localhost")){

    //MINIFY CSS

    //shared css
    $minCss = new \MatthiasMullie\Minify\CSS();
    $minCss->add(__DIR__."/../../../shared/styles/styles.css");
    $minCss->add(__DIR__."/../../../shared/styles/boot.css");

    //specific theme css
    $cssDir = scandir(__DIR__."/../../../themes/".CONF_THEME_APP."/assets/styles");
    foreach ($cssDir as $css){
        $cssFile = __DIR__."/../../../themes/".CONF_THEME_APP."/assets/styles/{$css}";
        if(is_file($cssFile) && pathinfo($cssFile)['extension'] == "css"){
            $minCss->add($cssFile);
        }
    }

    $minCss->minify( __DIR__."/../../../themes/".CONF_THEME_APP."/assets/style.css");

    //MINIFY JS

    //shared js
    $minJs = new \MatthiasMullie\Minify\JS();
    $minJs->add(__DIR__."/../../../shared/scripts/jquery-3.5.1.min.js");
    $minJs->add(__DIR__."/../../../shared/scripts/scripts.js");
    
    //specific theme js
    $jsDir = scandir(__DIR__."/../../../themes/".CONF_THEME_APP."/assets/scripts");
    foreach ($jsDir as $js){
        $jsFile = __DIR__."/../../../themes/".CONF_THEME_APP."/assets/scripts/{$js}";
        if(is_file($jsFile) && pathinfo($jsFile)['extension'] == 'js'){
            $minJs->add($jsFile);
        }
    }

    $minJs->minify(__DIR__."/../../../themes/".CONF_THEME_APP."/assets/scripts.js");



}

