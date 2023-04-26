<?php

namespace Core;

class Request {

    public function get($name){
        if (isset($_GET[$name])) {
            $array_secure = array();
            foreach ($_GET as $key => $value) {
                 $array_secure[$key] = htmlspecialchars(trim(stripslashes($value)));
            }
            return $array_secure;
        }
    }

    public function post($name){
        if (isset($_POST[$name])) {
            $array_secure = array();
            foreach ($_POST as $key => $value) {
                 $array_secure[$key] = htmlspecialchars(trim(stripslashes($value)));
            }
            return $array_secure;
        }
    }
}