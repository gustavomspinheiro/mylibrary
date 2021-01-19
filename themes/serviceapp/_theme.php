<?php
require __DIR__ . "/../../vendor/autoload.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <title>Gerencie a sua biblioteca</title>
        <meta charset="UTF-8">
        <meta name="mit" content="2020-09-27T20:21:24-03:00+172110">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?= url("/themes/" . CONF_THEME_APP . "/assets/style.css"); ?>">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400&display=swap" rel="stylesheet">

        <?= $head; ?>

    </head>

    <body class="app_body">

        <section class="app_container">
            <sidebar class="app_sidebar main_header">
                <nav class="main_header_nav">
                    <span class="main_header_nav_mobile_menu icon-menu" data-action="open_mobile"></span>
                    <div id="main_header_links" class="main_header_nav_links">
                        <ul class="app_sidebar_menu ">
                            <li><span class="main_header_nav_list_close icon-error"></span></li>
                            <li class="icon-dashboard app_sidebar_menu_item"><a href="<?= url("/app/");?>">Dashboard</a></li>
                            <li class="icon-book app_sidebar_menu_item"><a href="<?= url("/app/livros");?>">Busca por Título</a></li>
                            <li class="icon-tags app_sidebar_menu_item"><a>Busca por Categoria</a></li>
                            <li class="icon-comunication app_sidebar_menu_item"><a>Sugestão de Livros</a></li>
                            <li class="icon-exit app_sidebar_menu_item"><a href="<?= url("/sair"); ?>">Sair</a></li>
                        </ul>
                    </div>
                </nav>
            </sidebar>

            <article class="app_content">
                <?= flashMessage(); ?> 
                <main>
                    <?= $this->section("content"); ?>
                </main>
            </article>
        </section>
        <script src="<?= theme("/assets/scripts.js", CONF_THEME_APP);?>"></script>
    </body>
