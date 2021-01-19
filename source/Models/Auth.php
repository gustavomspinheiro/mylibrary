<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Source\Models;

use Source\Core\Model;
use Source\Models\User;
use Source\Core\Session;

/**
 * Description of Auth
 *
 * @author Gustavo Pinheiro
 */
class Auth extends Model {

    public function __construct() {
        parent::__construct("users", ["id"], ["email", "password"]);
    }

    public function register(User $user, string $confirmpass): bool {
        if ($user->findByEmail($user->email)) {
            $this->message = $this->message->error("Esse e-mail já está cadastrado")->render();
            return false;
        }

        if (!is_email($user->email)) {
            $this->message->warning("Oops! O formato do e-mail é inválido")->render();
            return false;
        }

        if (!is_passwd($user->password)) {
            $minPass = CONF_PASSWD_MIN_LEN;
            $maxPass = CONF_PASSWD_MAX_LEN;
            $this->message = $this->message->warning("Oops! A senha precisa conter entre {$minPass} e {$maxPass} caracteres")->render();
            return false;
        }

        if ($user->password != $confirmpass) {
            $this->message = $this->message->warning("Oops! A senha e a confirmação dessa precisam ser iguais. Tente novamente")->render();
            return false;
        }

        if (!$user->save()) {
            $this->message = $this->message->error("Oops! Algum problema ao salvar os dados. Tente novamente")->render();
            return false;
        }

        $this->message->success("Cadastro realizado com sucesso")->render();
        return true;
    }

    /**
     * Responsible for setting up the parameters that will be used to validate a login.
     * @param User $user
     * @return bool | User
     */
    public function login(string $email, string $password)
    {
        if (!is_email($email)) {
            $this->message = $this->message->warning("Oops! O e-mail não é válido. Tente novamente)")->render();
            return false;
        }

        if (!is_passwd($password)) {
            $this->message = $this->message->warning("Oops! A senha não é válida. Tente novamente)")->render();
            return false;
        }

        $user = (new User())->findByEmail($email);

        if (!$user) {
            $this->message = $this->message->error("Oops! Usuário não encontrado)")->render();
            return false;
        }

        if ($user->confirm != 1) {
            $this->message = $this->message->warning("Oops! Favor validar seu cadastro clicando no link recebido por e-mail :))")->render();
            return false;
        }

        if (!passwd_verify($password, $user->password)) {
            $this->message = $this->message->warning("A senha está incorreta. Tente novamente")->render();
            return false;
        }
        
        $session = (new Session())->set("user_id", $user->id);

        return $user;
    }

}
