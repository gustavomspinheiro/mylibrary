<?php $this->layout("_theme", ["head" => $head]); ?>
<article style="margin-top: 20px; text-align:center">
    <?=flashMessage();?>
    <header>
        <h1>Faça seu login</h1>
    </header>
    <form method="post" action="<?= url("/valida-login"); ?>">
        <input type="email" placeholder="Seu email:" name="email" required>
        <input type="password" placeholder="Sua senha:" name="password" required>
        <button type="submit" name="register_submit">Entrar</button>
    </form>
</article>

