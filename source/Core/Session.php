<?php

namespace Source\Core;

class Session
{

    /**
     * Session constructor.
     */
    public function __construct()
    {
        if(!session_id()){
            session_start();
        }
    }

    /**
     * Return session name.
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if(!empty($_SESSION[$name])) return $_SESSION[$name];

        return null;
    }

    /**
     * Return all the sessions
     * @return object|null
     */
    public function all(): ?object
    {
        return (object)$_SESSION;
    }

    /**
     * Sets the key to a function with its values in object format.
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function set(string $key, $value): Session
    {
        $_SESSION[$key] = (is_array($value) ? (object)$value : $value);
        return $this;
    }

    /**
     * @param $key
     * @return bool
     */
    public function __isset($key): bool
    {
        return $this->has($key);
    }

    /**
     * Unset a key parameter of the session and return the session.
     * @param $key
     * @return $this
     */
    public function __unset($key): Session
    {
        unset($_SESSION[$key]);
        return $this;
    }

    /**
     * Asks if the session has certain key. Boolean return.
     * @param $key
     * @return bool
     */
    public function has($key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Regenerates a certain session id.
     * @return $this
     */
    public function regenerate(): Session
    {
        session_regenerate_id(true);
        return $this;
    }

    /**
     * Destroys the session.
     * @return $this
     */
    public function destroy(): Session
    {
        session_destroy();
        return $this;
    }

    /**
     * Sets csrf_token parameter in the session.
     * @return $this
     */
    public function csrf(): Session
    {
        $_SESSION['csrf_token'] = md5(uniqid(rand(), true));
        return $this;
    }


}
