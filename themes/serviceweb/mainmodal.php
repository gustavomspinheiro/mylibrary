<article class="main_modal">
    <div class="main_modal_search">
        <div class="main_modal_search_title">
            <h1 class="icon-info">Descreva o caso do paciente</h1>
        </div>
        <form method="post" action="<?= url("/search") ?>" class="main_modal_search_form">
            <input name="case_desc" type="text" placeholder="Digite aqui...">
            <p>Preview:</p>
            <div class="main_modal_preview"></div>
            <button type="submit" class="button button_success main_modal_search_button">Buscar!</button>
        </form>
    </div>
</article>

