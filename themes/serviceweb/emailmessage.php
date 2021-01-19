<div>
    <h1>Falta pouco <?= $user->name ?>!</h1>
    <p>Para completar seu cadastro e começar a alugar os melhores livros, clique no link abaixo</p>
    <p><a href="<?= url("/obrigado/{$confirmlink}"); ?>"><?= $confirmlink;?></a</p>
</div>

