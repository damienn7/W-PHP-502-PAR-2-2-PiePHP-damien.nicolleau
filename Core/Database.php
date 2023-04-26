<?php

namespace Core;

class Database {
    private $db_name;

    private $db_user;

    private $db_pass;

    private $db_host;

    public $db;

    public function __construct(){
        $this->db = self::getPDO();
    }

    private function getPDO(){
        $pdo = new \PDO("mysql:dbname=".self::getDbName().";host=".self::getDbHost(),self::getDbUser(),self::getDbPass());
        $pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
        $this->db = $pdo;
        return $this->db;
    }

    private function getDbName(){
        return $this->db_name = Config::getInstance()->get("db_name");
    }

    private function getDbHost(){
        return $this->db_host = Config::getInstance()->get("db_host");
    }

    private function getDbUser(){
        return $this->db_user = Config::getInstance()->get("db_user");
    }
    private function getDbPass(){
        return $this->db_pass = Config::getInstance()->get("db_pass");
    }

}