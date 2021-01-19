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
        <link rel="stylesheet" href="<?= url("/themes/" . CONF_THEME_WEB . "/assets/style.css"); ?>">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400&display=swap" rel="stylesheet">

        <?= $head; ?>

    </head>

    <body>
        <header class="main_header">
            <div class="main_header_container">
                <a class="main_header_logo" href="<?=url();?>">
                    <img src="<?= image("images/lib-logo.png", 70); ?>" alt="Logo do buscador de CID" title="Logo do buscador de CID">
                </a>
                <nav class="main_header_nav">
                    <span class="main_header_nav_mobile_menu icon-menu" data-action="open_mobile"></span>
                    <div id="main_header_links" class="main_header_nav_links">
                        <ul class="main_header_nav_list">
                            <li><span class="main_header_nav_list_close icon-error"></span></li>
                            <li class="main_header_nav_list_item"><a href="<?= url("/login")?>"><span class="main_header_nav_list_item_text">Entrar</span></a></li>
                        </ul>
                    </div>
                </nav>
            </div>

        </header>

        <main>
            <?= $this->section("content") ?>
        </main>

        <footer class="web_footer">
            <section>
                <article>
                    <header>
                        <h1 class="web_footer_title">Quer saber mais?</h1>
                    </header>
                </article>
                <div class="footer_container">
                    <article class="footer_container_items">
                        <header>
                            <h2>Termos & Políticas</h2>
                        </header>
                        <a href="#" class="footer_container_items_terms">Aviso Legal</a>
                        <a href="#" class="footer_container_items_terms">Política de Privacidade</a>
                        <a href="#" class="footer_container_items_terms">Termos de Uso</a>
                    </article>

                    <article class="footer_container_items">
                        <header>
                            <h2>Contato</h2>
                        </header>
                        <p class="footer_container_items_about">Rua das Margaridas, 281</p>
                        <p class="icon-whatsapp footer_container_items_about"><span class="footer_container_items_about_text"> (11) 99127-4564</span></p>
                        <p class="icon-send footer_container_items_about"><span> gustavo.pinheiro21@gmail.com</span></p>
                    </article>

                    <article class="footer_container_items">
                        <header>
                            <h2><h2>Redes Sociais</h2></h2>
                        </header>
                        <a href="#" class="icon-facebook footer_container_items_social"></a>
                        <a href="#" class="icon-instagram footer_container_items_social"></a>
                        <a href="#" class="icon-youtube footer_container_items_social"></a>
                    </article>
                </div>
            </section>
        </footer>

        <article class="web_copyright">
            <span>© Todos os direitos reservados <?= date("Y") ?></span>
        </article>



        <script src="<?= theme("/assets/scripts.js"); ?>"></script>
        <?= $this->section("scripts") ?>
    </body>
</html>
