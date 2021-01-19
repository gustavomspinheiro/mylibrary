<?php $this->layout("_theme", ["head" => $head]); ?>
<article style="margin-top: 20px; text-align:center">
    <header>
        <h1>Cadastre-se aqui</h1>
    </header>
    <form method="post" action="<?= url("/valida-cadastro"); ?>">
        <input type="text" placeholder="Seu nome:" name="name" required>
        <input type="text" placeholder="Seu sobrenome:" name="surname" required>
        <input type="email" placeholder="Seu email:" name="email" required>
        <input type="password" placeholder="Sua senha:" name="password" required>
        <input type="password" placeholder="Confirme sua senha:" name="confirm_password" required>
        <button type="submit" name="register_submit">Cadastrar</button>
    </form>
    <small>Já possui cadastro? <a href="<?= url("/login"); ?>">Entrar</a></small>
</article>

