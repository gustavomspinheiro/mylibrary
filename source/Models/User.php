<?php


namespace Source\Models;
use Source\Core\Model;


class User extends Model
{
    public function __construct()
    {
        parent::__construct("users", ["id"], ["name","surname","email","password"]);
    }

    /**
     * Method responsible for preparing required user information.
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @return $this
     */
    public function bootstrap(string $firstName, string $lastName, string $email, string $password): User
    {
        $this->name = $firstName;
        $this->surname = $lastName;
        $this->email = $email;
        $this->password = $password;

        return $this;
    }

    /**
     * Method responsible for finding a user per email in users table.
     * @param string $email
     * @param string $columns
     * @return User|null
     */
    public function findByEmail(string $email, string $columns = "*"): ?User
    {
        $user = $this->find("email = :email", "email={$email}");
        return $user->fetch();
    }

    /**
     * Method responsible for providing user full name.
     * @return string
     */
    public function fullName(): string
    {
        return "{$this->name} {$this->surname}";
    }

    /**
     * Responsible for providing the path to the user photo
     * @return string|null
     */
    public function photo(): ?string
    {
        if($this->photo && file_exists(__DIR__."/../../".CONF_UPLOAD."/{$this->photo}")){
            return $this->photo;
        }

        return null;
    }

    /**
     * Method responsible for saving user data (updating or creating)
     * @return bool
     */
    public function save(): bool
    {

        if(!$this->required()){
            $this->message->warning("Nome, sobrenome, e-mail e senha são campos obrigatórios");
            return false;
        }

        if(!is_email($this->email)){
            $this->message->warning("O e-mail precisa ser válido. Tente novamente");
            return false;
        }

        if(!is_passwd($this->password)){
            $minPass = CONF_PASSWD_MIN_LEN;
            $maxPass = CONF_PASSWD_MAX_LEN;
            $this->message->warning("A senha deve conter entre {$minPass} e {$maxPass} caracteres");
            return false;
        }

        $this->password = passwd($this->password);


        //User Update
        if(!empty($this->id)){
            $userId = $this->id;
            $this->update($this->safe(), "id = :id", "id={$userId}");
            if($this->fail()){
                $this->message->error("Erro ao atualizar os dados. Tente novamente mais tarde");
                return false;
            }

        }

        //User Save
        if(empty($this->id)){
            $user = $this->findByEmail($this->email);
            if($user){
                $this->message->warning("O e-mail informado já está cadastrado");
                return false;
            }

            $userId = $this->create($this->safe());
            if($this->fail()){
                $this->message->error("Erro ao cadastrar. Tente novamente");
                return false;
            }

        }

        $this->data = $this->findById($userId)->data();
        return true;
    }


}