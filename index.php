<?php
ob_start();

require __DIR__."/vendor/autoload.php";

use CoffeeCode\Router\Router;

$router = new Router(CONF_URL_TEST);

/**
 * Web Routes
 */
$router->namespace("source\Controllers");

$router->get("/", "Web:home");
$router->get("/cadastro", "Web:register");
$router->get("/obrigado/{email}", "Web:confirmRegister");
$router->get("/login", "Web:login");
$router->post("/valida-cadastro", "Web:validateRegister");
$router->post("/valida-login", "Web:validateLogin");
$router->get("/sair", "Web:logout");

/**
 * App Routes
 */
$router->namespace("source\Controllers");
$router->group("/app");
$router->get("/", "App:home");
$router->get("/{name}", "App:library");
$router->get("/{tipo}/livros", "App:books");
$router->post("/pesquisa", "App:bookSearch");
$router->get("/pesquisa/{search}/{page}", "App:bookSearchRefined");
$router->post("/alugar", "App:bookRent");
$router->get("/sugestoes", "App:suggestions");
$router->post("/devolver/{order}", "App:returnBook");
$router->post("/pesquisa-categoria", "App:categorySearch");
$router->get("/pesquisa-categoria/{search}/{page}", "App:categorySearchRefined");



/**
 * Error Routes
 */
$router->namespace("source\Controllers");

$router->group("ops");

$router->get("/{errcode}", "Web:error");


/**
 * Dispatch Routes
 */
$router->dispatch();


/**
 * Redirect Errors
 */
if($router->error())
{
    $router->redirect("/ops/{$router->error()}");
}

ob_end_flush();

