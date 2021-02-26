<?php $this->layout("_theme", ["head" => $head]); ?>
<?php if (!empty($books)): ?>
    <header class="books_list_header">
        <h2>Sugestões</h2>
    </header>
    <article>
        <h4>
            Consumo de API externa para listagem de últimos livros publicados nela nos últimos 120 dias com limite de <?= $limit ?> livro(s)
        </h4>

        <div>
            <div class="books_list_article">
                <?php for ($i = 1; $i <= $limit; $i++): ?>
                    <div class="books_list">
                        <h4><?= $books[$i]->titulo; ?></h4>
                        <p class="books_list_info">Editora: <?= $books[$i]->editora->nome_fantasia; ?> | Publicado em: <?= $books[$i]->data_publicacao; ?> </p>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </article>


<?php else: ?>
    <h3>Oops!</h3>
    <p>Não há sugestões no momento :)</p>
<?php endif; ?>   






