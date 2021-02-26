<?php $this->layout("_theme", ["head" => $head]); ?>

<article>
    <div class="book_search">
        <div class="book_search_header">
            <h1>Olá <?= $user->name; ?>! Qual livro você gostaria de alugar hoje?</h1>
        </div>

        <div class="book_search_form">
            <?php if (!$categoryLayout): ?>
                <form  method="post" action="<?= url("/app/pesquisa"); ?>">
                    <input class="book_search_form_text" type="text" name="s" placeholder="Busque por título ou resumo do livro..." required>
                    <input class="book_search_form_submit" type="submit" value="Buscar">
                </form>
            <?php else: ?>
                <form  method="post" action="<?= url("/app/pesquisa-categoria"); ?>">
                    <input class="book_search_form_text" type="hidden" value="s" name="s">
                    <select name="category" class="book_search_form_text">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category->category; ?>" name="<?= $category->category; ?>"><?= $category->category; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input class="book_search_form_submit" type="submit" value="Buscar">
                </form>
            <?php endif; ?>

        </div>
    </div>
</article>

<?php if (!empty($search)): ?>
    <?php if (!empty($books)): ?>
        <header class="books_list_header">
            <h2>Lista de livros</h2>
        </header>
        <div>
            <div class="books_list_article">
                <?php foreach ($books as $book): ?>
                    <div class="books_list">
                        <h4><?= $book->title; ?> (p. <?= $book->pages_count; ?>)</h4>
                        <p class="books_list_info">Autor(a): <?= $book->author; ?> | Publicado em: <?= date_fmt($book->publish_date, "d/M/Y"); ?> </p>
                        <div class="books_list_cover"><img src="<?= image("/images/" . $book->image, 100); ?>"></div>
                        <p class="books_list_summary"><?= str_limit_words($book->summary, 15, "..."); ?></p>
                        <p class="books_list_quantity">Quantidade disponível: <b><?= $book->inventory; ?></b></p>
                        <form method="post" action="<?= url("/app/alugar"); ?>">
                            <input type="hidden" name="book" value="<?= $book->id; ?>">
                            <input type="submit" value="Alugar" class="button button_success">
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
            <?= $paginator; ?>
        </div>

    <?php else: ?>
        <h3>Oops!</h3>
        <p>Não foram encontrados resultados para a busca <b><?= $search; ?></b></p>
        <p>Tente um outro termo :)</p>
    <?php endif; ?>   

<?php endif; ?>




