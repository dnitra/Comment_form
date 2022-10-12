<?php

class Errors
{

    public ?string $name = "The name is required!";
    public ?string $comment = "There is no comment!";
    public ?string $general = "You are missing some data!";

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
        $keys = [
            "name" => $this->name,
            "comment" => $this->comment,
            "general" => $this->general
        ];

        $this->errors[$key] = $keys[$key];
    }
}
