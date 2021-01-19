<?php

namespace Source\Support;

use PHPMailer\PHPMailer\PHPMailer;
use Source\Support\Message;

class Email {
    /*     * @var PHPMailer */

    private $email;

    /*     * @var stdClass */
    private $data;

    /*     * @var Message */
    private $message;

    /**
     * Responsible for initiating e-mail.
     */
    public function __construct() {
        $this->email = new PHPMailer(true);
        $this->data = new \stdClass();
        $this->message = new Message();

        //server settings
        $this->email->isSMTP();
        $this->email->isHTML(true);
        $this->email->SMTPDebug = 0;
        $this->email->Host = CONF_MAIL_HOST;
        $this->email->setLanguage(CONF_MAIL_OPTION_LANG);
        $this->email->SMTPAuth = true;
        $this->email->Username = CONF_MAIL_USER;
        $this->email->Password = CONF_MAIL_PASS;
        $this->email->Port = CONF_MAIL_PORT;
        $this->email->SMTPSecure = CONF_MAIL_OPTION_SECURE;
        $this->email->CharSet = CONF_MAIL_OPTION_CHARSET;
    }

    /**
     * Responsible for preparing information for e-mail send.
     * @param string $subject
     * @param type $body
     * @param string $recipientName
     * @param string $recipientEmail
     * @return \Source\Support\Email
     */
    public function bootstrap(string $subject, $body, string $recipientName, string $recipientEmail): Email {
        $this->data->subject = $subject;
        $this->data->body = $body;
        $this->data->recipientName = $recipientName;
        $this->data->recipientEmail = $recipientEmail;
        return $this;
    }

    /**
     * Method responsible for attaching files to e-mail
     * @param string $path
     * @param string|null $altName
     * @return \Source\Support\Email|null
     */
    public function addAttachment(string $path, ?string $altName = null): ?Email {
        if (file_exists($path) && is_file($path)) {

            if ($altName) {
                $this->email->addAttachment(url($path), $altName);
                return $this;
            }

            $this->email->addAttachment(url($path));
            return $this;
        }

        return null;
    }

    /**
     * Method responsible for adding a copy into the e-mail
     * @param string $name
     * @return \Source\Support\Email
     */
    public function addCopy(string $name): Email {
        $this->email->addCC($name);
        return $this;
    }

    /**
     * Method responsible for sending the e-mail.
     * @return bool
     */
    public function sendMail(): bool {
        try {
            $this->email->setFrom(CONF_MAIL_SENDER["address"], CONF_MAIL_SENDER["name"]);
            $this->email->addAddress($this->data->recipientEmail, $this->data->recipientName);
            $this->email->Subject = $this->data->subject;
            $this->email->msgHTML($this->data->body);
            $this->email->send();
            return true;
        } catch (Exception $ex) {
            $this->message->error("Erro ao enviar a mensagem. Informações: {$ex->getMessage()}");
            var_dump($ex->getMessage());
            return false;
        }
    }

}
