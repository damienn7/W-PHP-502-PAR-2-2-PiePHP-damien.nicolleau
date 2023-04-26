<?php

namespace Core;

class Config
{
    private $id;
    private static $_instance;
    private $settings = [];

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Config();
        }
        return self::$_instance;
    }
    public function __construct()
    {
        $this->id = uniqid();
        $this->settings = [
            "db_user" => getenv("db_user"),
            "db_pass" => getenv("db_pass"),
            "db_host" => getenv("db_host"),
            "db_name" => getenv("db_name")
        ];
    }

    public function get($key)
    {
        if (!isset($this->settings[$key])) {
            return null;
        }
        return $this->settings[$key];
    }
}