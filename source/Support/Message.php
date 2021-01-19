<?php

namespace Source\Support;

use Source\Core\Session;

class Message
{
    /** @var type string*/
    private $text;

    /** @var type string*/
    private $type;

    /** @var type string*/
    private $before;

    /** @var type string*/
    private $after;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * Responsible for ordering the message text.
     * @return string
     */
    public function getText(): string
    {
        return $this->before.$this->text.$this->after;
    }

    /**
     * Responsible for returning the message type (error, info, warning, etc)
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Responsible for setting the text that is going to be "published" before the message.
     * @param string $message
     * @return $this
     */
    public function before(string $message): Message
    {
        $this->before = $this->filter($message);
        return $this;
    }

    /**
     * Responsible for setting the text that is going to be "published" after the message.
     * @param string $message
     * @return $this
     */
    public function after(string $message): Message
    {
        $this->after = $this->filter($message);
        return $this;
    }

    /**
     * Responsible for setting info class to the message.
     * @param string $message
     * @return $this
     */
    public function info(string $message): Message
    {
        $this->text = $this->filter($message);
        $this->type = "button_info icon-info";
        return $this;
    }

    /**
     * Responsible for setting error class to the message.
     * @param string $message
     * @return $this
     */
    public function error(string $message): Message
    {
        $this->text = $this->filter($message);
        $this->type = "button_error icon-error";
        return $this;
    }

    /**
     * Responsible for setting warning class to the message.
     * @param string $message
     * @return $this
     */
    public function warning(string $message): Message
    {
        $this->text = $this->filter($message);
        $this->type = "button_warning icon-warning";
        return $this;
    }

    /**
     * Responsible for setting success class to the message.
     * @param string $message
     * @return $this
     */
    public function success(string $message): Message
    {
        $this->text = $this->filter($message);
        $this->type = "button_success icon-success";
        return $this;
    }

    /**
     * Responsible for organizing the div with the appropriate type and text.
     * @return string
     */
    public function render():string
    {
        return "<div class='message button {$this->getType()}'>{$this->getText()}</div>";
    }

    /**
     * Responsible for setting the object to flash key in the session.
     */
    public function flash(): void
    {
        (new Session())->set("flash", $this);

    }

    /**
     * Responsible for filtering the messages that are going to be written.
     * @param string $message
     * @return string
     */
    private function filter(string $message): string
    {
        return filter_var($message, FILTER_SANITIZE_STRIPPED);
    }

}
