<?php
namespace Core;

class autoload {

    static function register(){
        try{
            spl_autoload_register(array(__CLASS__,'autoloader'));
        }catch(\Exception $e) {
            echo $e;
        }
    }

    static function autoloader($classname){
        require str_replace('\\','/',$classname).'.php';
    }
}