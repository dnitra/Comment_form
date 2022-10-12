<?php

class Session
{

    public static $initialize = null;


    public static function initialize(): Session
    {


        if (static::$initialize === null) {

            static::$initialize = new Session();
        }

        return static::$initialize;
    }

    public array $data = [];

    public function __construct()
    {
        session_start();
        $this->data = $_SESSION;
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
        $_SESSION[$key] = $value;
    }

    public function handleMessage($key)
    {
      
        $message = $_SESSION[$key];
        unset($_SESSION[$key]);

        return $message;
    }
}
