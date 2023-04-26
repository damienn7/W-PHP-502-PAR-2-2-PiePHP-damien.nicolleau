<?php
namespace Core;

use Core\Router;
use src\Controller\AppController;
use src\Controller\UserController;

class Core
{
    public function run()
    {
        echo str_replace("\\", " ", __CLASS__) . "[OK]" . PHP_EOL;
        //mise a jour de la methode run de la classe Core 
        //pour charger le fichier src/routes.php 

        //utile au routage statique
        //require_once('/var/www/mvc.fr/src/routes.php');

        //utile au routage statique
        $router = new Router();


        if (count(explode("/", $_SERVER["REQUEST_URI"])) === 3) {
            if (substr(explode("&", str_replace("?", "", explode("/", $_SERVER["REQUEST_URI"])[2]))[0], 0, -1) == "?") {
                $param = substr(explode("&", str_replace("?", "", explode("/", $_SERVER["REQUEST_URI"])[2]))[0], 0, -1);
            } else {
                $param = explode("&", str_replace("?", "", explode("/", $_SERVER["REQUEST_URI"])[2]))[0];
            }
            //echo $param;
            if (is_numeric($param)) {

                preg_match('/({(.*)})/', file_get_contents("/var/www/mvc.fr/src/routes.php"), $match);

                if (!is_bool($match)) {
                    $return_value = $router->get(str_replace(explode("&", str_replace("?", "", explode("/", $_SERVER["REQUEST_URI"])[2]))[0], $match[0], $_SERVER["REQUEST_URI"]));
                    //echo str_replace(explode("&",str_replace("?","",explode("/",$_SERVER["REQUEST_URI"])[2]))[0],$match[0],$_SERVER["REQUEST_URI"]);
                } else {
                    $app = new AppController();
                    $action = "pageNotFound";
                    call_user_func_array([$app, $action], []);
                    return;
                }

            } else {
                $return_value = $router->get($_SERVER["REQUEST_URI"]);
            }
        } else {
            $return_value = $router->get($_SERVER["REQUEST_URI"]);
        }






        //utile au routage dynamique
        //Router::get($_SERVER["REQUEST_URI"]);

        // routage statique ci-dessous
        if (is_array($return_value)) {
            $i = 0;
            foreach ($return_value as $key => $value) {
                if ($i == 0) {
                    $key_ = $key;
                } else {
                    $key__ = $key;
                }
                $i++;
            }

            if (isset($return_value[$key_])) {
                if (is_string($return_value[$key_]) && is_string($return_value[$key__])) {


                    $controllerfile = str_replace("Core", "", __DIR__) . "/src/Controller/" . ucfirst($return_value[$key_]) . "Controller.php";

                    $content = file_get_contents($controllerfile);
                    $action = $return_value[$key__] . ucfirst($key__);
                    $name = ucfirst($return_value[$key_]) . ucfirst($key_);

                    $controller = "src\\Controller\\" . $name;
                    if ($content === false) {
                        $app = new AppController();
                        $action = "pageNotFound";
                        call_user_func_array([$app, $action], []);
                    } else {
                        $find = $action;
                        $pos = strpos($content, $find);
                        if ($pos === false) {
                            $app = new AppController();
                            $action = "pageNotFound";
                            call_user_func_array([$app, $action], []);
                        } else {
                            if (isset($match)) {
                                $controller = new $controller();
                                if (substr(explode("&", str_replace("?", "", explode("/", $_SERVER["REQUEST_URI"])[2]))[0], 0, -1) == "?") {
                                    $controller->$action();
                                } else {
                                    $controller->$action(explode("&", str_replace("?", "", explode("/", $_SERVER["REQUEST_URI"])[2]))[0]);
                                }
                            } else {
                                $controller = new $controller();
                                call_user_func_array([$controller, $action], []);
                            }
                        }
                    }
                }
            } else {
                $app = new AppController();
                $action = "pageNotFound";
                call_user_func_array([$app, $action], []);
            }
        } elseif ($return_value != true) {
            $app = new AppController();
            $action = "pageNotFound";
            call_user_func_array([$app, $action], []);
        }
    }
}

?>