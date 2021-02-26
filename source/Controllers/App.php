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
use Source\Models\Category;
use Source\Models\Order;
use Source\Models\External\BookApi;
use Source\Support\Message;
use CoffeeCode\Paginator\Paginator;

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
        $order = new Order();

        $order->calculateFine($this->user);

        $nextReturn = $order->nextReturn($this->user);
        $orders = $order->listOrders($this->user)->fetch(true);
        $ordersCount = $order->listOrders($this->user)->count();
        $fines = $order->sumFine($this->user)->fetch();
        $fines = $fines->fines;
        $totalOrders = $order->listOrders($this->user, "")->count();

        echo $this->view->render("dashboard", [
            "head" => $head,
            "orders" => $orders,
            "ordersCount" => $ordersCount,
            "pendingFines" => $fines,
            "nextReturn" => $nextReturn,
            "totalOrders" => $totalOrders
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
        $dataRef = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $categories = '';
        $categoryLayout = '';

        if ($dataRef['tipo'] == "c") {
            $categoryLayout = true;
            $categories = (new Category())->find()->fetch(true);
        }

        echo $this->view->render("books", [
            "head" => $head,
            "books" => '',
            "user" => $this->user(),
            "categoryLayout" => $categoryLayout,
            "categories" => $categories
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
            $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
            $pageRev = (!empty($page) ? $page : 1);
            echo json_encode(["redirect" => url("/app/pesquisa/{$search}/{$pageRev}")]);
            return;
        } else {
            echo json_encode(["message" => $this->message->warning("Favor informar um texto de pesquisa")->render()]);
            return;
        }
    }

    /**
     * Responsible for searching the books and rendering view
     * @param array $data
     * @return void
     */
    public function bookSearchRefined(array $data): void {
        if ($data["search"]) {
            $search = filter_var($data["search"], FILTER_SANITIZE_STRIPPED);
            $books = (new Book())->bookSearch($search);

            $page = (!empty($data['page']) ? filter_var($data['page'], FILTER_VALIDATE_INT) : 1);

            $pager = new Paginator(url("/app/pesquisa/{$search}/"));
            $pager->pager($books->count(), 3, $page);


            $head = $this->seo->render(
                    CONF_SITE_TITLE,
                    CONF_SITE_DESC,
                    url(),
                    theme("/assets/images/share.png"),
                    true);

            echo $this->view->render("books", [
                "head" => $head,
                "books" => $books->limit($pager->limit())->offset($pager->offset())->fetch(true),
                "user" => $this->user(),
                "search" => $search,
                "paginator" => $pager->render(),
                "categoryLayout" => false
            ]);

            return;
        }

        $this->message->error("Erro na aplicação. Favor tentar novamente mais tarde :/")->flash();
        redirect(url("/app"));
        return;
    }

    /**
     * Responsible for handle search and redirect route
     * @param array $data
     * @return void
     */
    public function categorySearch(?array $data): void {
        if (!empty($data['s'])) {
            $dataRev = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $category = strtolower($dataRev["category"]);
            $page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
            $pageRev = (!empty($page) ? $page : 1);
            echo json_encode(["redirect" => url("/app/pesquisa-categoria/{$category}/{$pageRev}")]);
            return;
        } else {
            echo json_encode(["message" => $this->message->warning("Favor informar a categoria")->render()]);
            return;
        }
    }

    /**
     * Responsible for rendering results for search by category
     * @param array $data
     * @return void
     */
    public function categorySearchRefined(array $data): void {
        if ($data["search"]) {
            $search = filter_var($data["search"], FILTER_SANITIZE_STRIPPED);
            $books = (new \Source\Models\Book())->searchByCategory($search);

            $page = (!empty($data['page']) ? filter_var($data['page'], FILTER_VALIDATE_INT) : 1);

            $pager = new Paginator(url("/app/pesquisa-categoria/{$search}/"));
            $pager->pager($books->count(), 3, $page);


            $head = $this->seo->render(
                    CONF_SITE_TITLE,
                    CONF_SITE_DESC,
                    url(),
                    theme("/assets/images/share.png"),
                    true);

            echo $this->view->render("books", [
                "head" => $head,
                "books" => $books->limit($pager->limit())->offset($pager->offset())->fetch(true),
                "user" => $this->user(),
                "search" => $search,
                "categoryLayout" => true,
                "categories" => (new Category())->find()->fetch(true),
                "paginator" => $pager->render(),
                    
            ]);

            return;
        }

        $this->message->error("Erro na aplicação. Favor tentar novamente mais tarde :/")->flash();
        redirect(url("/app"));
        return;
    }

    /**
     * Responsible for registering the rent
     * @param array $data
     * @return void
     */
    public function bookRent(array $data): void {
        $dataRefined = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $book = (new Book())->findById($dataRefined["book"]);

        if ($book->inventory < 1) {
            echo json_encode(["message" => $this->message->error("O livro não está mais disponível")->render()]);
            return;
        }

        $order = (new Order())->bootstrap($this->user, $book);


        if (!$order->save()) {
            echo json_encode(["message" => $this->message->error("Erro ao processar. Tente novamente")->render()]);
            return;
        }

        $book->inventory -= 1;
        $book->save();
        $this->message->success("Livro reservado com sucesso")->flash();
        echo json_encode(["redirect" => url("/app/{$this->user->id}")]);
        return;
    }

    public function suggestions(?array $data): void {

        //API consumption
        $api = new BookApi();
        $uri = $api->searchByDate("now", "P120D");

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $uri);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);
        curl_close($curl);
        $books = [];



        if (json_decode($response)->status->success) {
            $books = (json_decode($response))->books;
        }

        $head = $this->seo->render(
                CONF_SITE_TITLE,
                CONF_SITE_DESC,
                url(),
                theme("/assets/images/share.png"),
                true);

        echo $this->view->render("suggestions", [
            "head" => $head,
            "books" => $books,
            "limit" => 4
        ]);
    }

    public function returnBook(array $data): void {
        $dataRev = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $order = (new Order())->findById($dataRev["order"]);

        if (!$order) {
            $json["message"] = (new Message())->error("Erro no sistema")->render();
            echo json_encode($json);
            return;
        }

        $book = (new Book())->findById($order->data->book);

        if (!$book) {
            $json["message"] = (new Message())->error("Livro inexistente")->render();
            echo json_encode($json);
            return;
        }

        $order->status = 'concluded';
        $order->save();

        $book->inventory += 1;
        $book->save();

        $json["message"] = (new Message())->success("Livro devolvido com sucesso")->flash();
        $json["reload"] = true;
        echo json_encode($json);
        return;
    }

}
