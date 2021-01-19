<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Source\Controllers;

require __DIR__ . "/../Boot/Minify/AppMinify.php";

use Source\Core\Controller;
use Source\Core\Session;
use Source\Models\User;
use Source\Models\Book;

/**
 * Description of App
 *
 * @author Gustavo Pinheiro
 */
class App extends Controller {

    /** @var */
    private $user;

    public function __construct() {
        parent::__construct(__DIR__ . "/../../" . CONF_THEME_PATH_APP . "/");
        $id = (new Session())->user_id;
        if (!$id) {
            $this->message->info("Você deve estar logado para continuar :)")->flash();
            redirect(url("/login"));
            exit;
        }

        $this->user = (new User())->findById($id);
    }

    /**
     * Responsible for returning the user
     * @return User
     */
    public function user(): User {
        return $this->user;
    }

    /**
     * Redirects to login page (if user tries to access /app directly)
     * @return void
     */
    public function home(): void {
        redirect(url("/login"));
    }

    public function library(array $data): void {
        $head = $this->seo->render(
                CONF_SITE_TITLE,
                CONF_SITE_DESC,
                url(),
                theme("/assets/images/share.png"),
                true);

        echo $this->view->render("dashboard", [
            "head" => $head
        ]);
    }

    /**
     * Responsible for rendering books page
     * @param array $data
     * @return void
     */
    public function books(?array $data): void {
        $head = $this->seo->render(
                CONF_SITE_TITLE,
                CONF_SITE_DESC,
                url(),
                theme("/assets/images/share.png"),
                true);

        echo $this->view->render("books", [
            "head" => $head,
            "books" => '',
            "user" => $this->user()
        ]);
    }

    /**
     * 
     * @param array $data
     * @return void
     */
    public function bookSearch(?array $data): void {
        if ($data['s']) {
            $search = filter_var($data['s'], FILTER_SANITIZE_STRIPPED);
            echo json_encode(["redirect" => url("/app/pesquisa/{$search}")]);
            return;
        } else {
            echo json_encode(["message" => $this->message->warning("Favor informar um texto de pesquisa")->render()]);
            return;
        }
    }

    public function bookSearchRefined(array $data): void {
        if ($data["search"]) {
            $search = filter_var($data["search"], FILTER_SANITIZE_STRIPPED);
            $books = (new Book())->bookSearch($search);

            $head = $this->seo->render(
                    CONF_SITE_TITLE,
                    CONF_SITE_DESC,
                    url(),
                    theme("/assets/images/share.png"),
                    true);

            echo $this->view->render("books", [
                "head" => $head,
                "books" => $books,
                "user" => $this->user(),
                "search" => $search
            ]);
            
            return;
        }

        $this->message->error("Erro na aplicação. Favor tentar novamente mais tarde :/")->flash();
        redirect(url("/app"));
        return;
    }

}
