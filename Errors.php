<?php

class Errors
{
    public array $messages = [
        "name" => "The name is required!",
        "comment" => "There is no comment!",
        "general" => "You are missing some data!",
        "default" => "Somethng went wrong!"
    ];
    public  array $errors = [];

    public static $initialize = null;
    public static function initialize(): Errors
    {
        if (static::$initialize === null) {

            static::$initialize = new Errors();
        }
        return static::$initialize;
    }

    public function set($key)
    {
        if (isset($this->messages[$key])) {
            $this->errors[$key] = $this->messages[$key];
        } else {
            $this->errors[$key] = $this->messages["default"];
        }
    }
}
