<?php

namespace Source\Controllers;

use Source\Core\Controller;
use Source\Core\Session;
use Source\Models\Auth;
use Source\Models\User;
use Source\Support\Email;

require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../Boot/Minify/WebMinify.php";

class Web extends Controller {

    public function __construct() {
        parent::__construct(__DIR__ . "/../../" . CONF_THEME_PATH_WEB . "/");
    }

    /**
     * Responsible for rendering the home page.
     */
    public function home(): void {
        $head = $this->seo->render(
                CONF_SITE_TITLE,
                CONF_SITE_DESC,
                url(),
                theme("/assets/images/share.png"),
                true);

        echo $this->view->render("home", [
            "head" => $head
        ]);
    }

    /**
     * Responsible for rendering the register page.
     */
    public function register(): void {
        $head = $this->seo->render(
                CONF_SITE_TITLE,
                CONF_SITE_DESC,
                url(),
                theme("/assets/images/share.png"),
                true);

        echo $this->view->render("register", [
            "head" => $head
        ]);
    }

    public function validateRegister(array $data): void {

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $user = (new User())->bootstrap($data["name"], $data["surname"], $data["email"], $data["password"]);
        $mail = (new Email());
        $auth = new Auth();
        $register = $auth->register($user, $data["confirm_password"]);

        if ($register) {
            $message = $this->view->render("emailmessage", [
                "confirmlink" => base64_encode($user->email),
                "user" => $user
            ]);

            $send = $mail->bootstrap("Cadastro Sistema MyLibrary", $message, $user->name, $user->email)->sendMail();
            if ($send) {
                $json["message"] = $this->message->success("Legal {$user->name}! Seu cadastro está quase completo. Abra o seu e-mail para fazer a confirmação")->render();
                echo json_encode($json);
                return;
            } else {
                $json["message"] = $this->message->error("Oops! {$user->name}! Não foi possível enviar o e-mail de confirmação.")->render();
                echo json_encode($json);
                return;
            }
        }

        $json["message"] = $auth->message;
        echo json_encode($json);
        return;
    }

    public function confirmRegister(array $data): void {
        $email = base64_decode(filter_var($data['email'], FILTER_SANITIZE_STRIPPED));
        $user = (new User())->findByEmail($email);
        $user->confirm = 1;
        $user->save();
        redirect(url("/login"));
    }

    /**
     * Responsible for rendering login page
     * @return void
     */
    public function login(): void {

        $session = (new Session());
        if ($session->user_id) {
            redirect(url("/app/{$session->user_id}"));
        }

        $head = $this->seo->render(
                CONF_SITE_TITLE,
                CONF_SITE_DESC,
                url(),
                theme("/assets/images/share.png"),
                true);

        echo $this->view->render("login", [
            "head" => $head
        ]);
    }

    /**
     * Responsible for validating user´s login
     * @param array $data
     * @return void
     */
    public function validateLogin(array $data): void {
        $dataFiltered = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $user = (new User())->findByEmail($dataFiltered['email']);
        $auth = new Auth();

        if (!$user) {
            $json['message'] = $this->message->warning("Oops! Usuário inexistente")->render();
            echo json_encode($json);
            return;
        }

        if ($auth->login($dataFiltered['email'], $dataFiltered['password'])) {
            $user->message->success("Sucesso! Seja bem vindo(a) {$user->name} :)")->flash();
            $name = strtolower($user->name);
            $json['redirect'] = url("/app/{$name}");
            echo json_encode($json);
            return;
        }

        $json['message'] = $auth->message;
        echo json_encode($json);
        return;
    }

    public function logout(): void {
        $session = new Session();
        unset($_SESSION['user_id']);
        $session->destroy();
        $this->message->success("Logout realizado com sucesso. Volte sempre :)")->flash();
        redirect(url("/login"));
    }

    public function error(?array $data): void {
        $errcode = filter_var($data["errcode"], FILTER_VALIDATE_INT);

        $head = $this->seo->render(
                "Erro: Gerenciador de Bibliotecas",
                CONF_SITE_DESC,
                url(),
                theme("/assets/images/share.png"),
                false);

        echo $this->view->render("error", [
            "head" => $head,
            "errcode" => $errcode
        ]);
    }

}
