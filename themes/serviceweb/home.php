<?php $this->layout("_theme", ["head" => $head]); ?>

<div class="main_container">
    <section>
        <div class="main_banner_headline">
            <div class="main_headline">
                <h1>Aluguel de Livros</h1>
                <div class="main_separator"></div>
                <ul>
                    <li><span class="icon-arrow-right"></span>Procure livros no catálogo da biblioteca</li>
                    <li><span class="icon-arrow-right"></span>Verifique se o livro desejado está disponível para aluguel</li>
                    <li><span class="icon-arrow-right"></span>Gerencie o prazo de devolução facilmente</li>
                </ul>
                <a data-modal=".main_modal" class="main_headline_button" href="<?= url("/cadastro")?>">Cadastrar</a>

            </div>

            <div class="main_banner">
                <div class="main_banner_images">
                    <img src="<?= image("images/lib-banner.png", 350); ?>" class="main_banner_images_active" alt="Gerenciador de Biblioteca" title="Gerenciador de Biblioteca">
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="main_highlights">
            <header>
                <h1><span class="icon-search"></span>Livros Mais Pesquisados</h1>
                <h2>Os livros mais buscados na sua categoria</h1>
            </header>

            <div class="main_highlights_session">
                <h3 class="main_highlights_title">Suspense</h3>
                <span class="main_highlight_button icon-plus"></span>
                <ul class="main_highlights_list">
                    <li><span>Número: </span><span>Lorem ipsum</span></li>
                    <li><span>Número: </span><span>Lorem ipsum</span></li>
                    <li><span>Número: </span><span>Lorem ipsum</span></li>
                </ul>
            </div>

            <div class="main_highlights_session">
                <h3 class="main_highlights_title">Biografia</h3>
                <span class="main_highlight_button icon-plus"></span>
                <ul id="test" class="main_highlights_list">
                    <li><span>Número: </span><span>Lorem ipsum</span></li>
                    <li><span>Número: </span><span>Lorem ipsum</span></li>
                    <li><span>Número: </span><span>Lorem ipsum</span></li>
                </ul>
            </div>

            <div class="main_highlights_session">
                <h3 class="main_highlights_title">Ação</h3>
                <span class="main_highlight_button icon-plus"></span>
                <ul class="main_highlights_list">
                    <li><span>Número: </span><span>Lorem ipsum</span></li>
                    <li><span>Número: </span><span>Lorem ipsum</span></li>
                    <li><span>Número: </span><span>Lorem ipsum</span></li>
                </ul>
            </div>
        </div>
    </section>

    <section class="main_benefits">
        <article>
            <header>
                <h1 class="main_benefits_title">Conheça os Benefícios do Nosso Sistema</h1>
            </header>
        </article>

        <article class="main_benefits_category">
            <header>
                <h2 class="main_benefits_category_title">Hospitais</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
            </header>

            <img class="main_benefits_category_image" src="<?= image("images/hospital-benefits-cid-search.png", 400) ?>">

        </article>

        <article class="main_benefits_category">

            <img class="main_benefits_category_image" src="<?= image("images/researcher-benefits-cid-search.png", 400) ?>">

            <header style="text-align:right" class="align_text_right">
                <h2 class="main_benefits_category_title">Pesquisadores</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
            </header>

        </article>

        <article class="main_benefits_category">
            <header>
                <h2 class="main_benefits_category_title">Médicos</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
            </header>

            <img class="main_benefits_category_image" src="<?= image("images/doctor-benefits-cid-search.png", 400) ?>">

        </article>

    </section>

    <section>
        <article class="main_call_action">
            <header>
                <h1 class="main_call_action_title">O que está esperando?</h1>
            </header>
            <h2 class="main_call_action_subtitle">Alugue seus livros preferidos com poucos cliques!</h2>
            <p><a class="main_call_action_button button button_success">QUERO ALUGAR</a></p>
        </article>
    </section>
</div>





