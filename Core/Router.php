<?php

namespace Core;

//use utilises pour le routage statique 
use src\Controller\AppController;
use src\Controller\UserController;
//use utilise pour le routage dynamique
use src\routes;

class Router
{
    private static $routes;

    private static $bool = false;

    //la methode connect permet d'ajouter une route au framework
    //utile au routage statique
    public static function connect($url, $route)
    {
        self::$bool = true;
        self::$routes[$url] = $route;
    }

    public static function call($url)
    {
        
        if (is_string($url)) {
            $params = explode("/", $url);
            if ($url == "/") {
                $app = new AppController();
                $action = "indexAction";
                call_user_func_array([$app, $action], []);
                return true;
            }

            if ($params[1] != "") {
                $name = ucfirst($params[1]);
            }

            $controller = "src\\Controller\\" . $name . "Controller";
            if (isset($params[2])) {
                if ($params[2] != "") {
                    $action = $params[2] . "Action";
                }
            } else {
                $app = new AppController();
                $action = "pageNotFound";
                call_user_func_array([$app, $action], []);
                return true;
            }

            $controllerfile = str_replace("Core", "", __DIR__) . "/src/Controller/" . $name . "Controller.php";

            $content = file_get_contents($controllerfile);

            if ($content === false) {
                $app = new AppController();
                $action = "pageNotFound";
                call_user_func_array([$app, $action], []);
            } else {
                $find = $action;
                $pos = strpos($content, $find);
                if ($pos === false || $action == "") {
                    $app = new AppController();
                    $action = "pageNotFound";
                    call_user_func_array([$app, $action], []);
                } else {
                    $controller = new $controller();
                    call_user_func_array([$controller, $action], []);
                }
            }
        } else {
            $app = new AppController();
            $action = "pageNotFound";
            call_user_func_array([$app, $action], []);
        }

        return true;
    }
    public static function get($url)
    {

        //  retourne  un  tableau  associatif  contenant
        // - le  controller a instancier
        // - la  methode  du  controller a appeler

        require (str_replace("Core", "", __DIR__) . 'src/routes.php');

        //routage statique ci-dessous
        if (self::$bool === false) {
            return self::call($url);
        } else {
            if (array_key_exists($url, self::$routes)) {
                return self::$routes[$url];
            } else {
            //     return 0;
                return self::call($url);
            }   
        }

        //      ||
        //      ||
        //\\\\\\||//////
        // \\\\\\//////
        //  \\\\\/////
        //   \\\\////
        //    \\\///
        //     \\//
        //      \/

        // routage dynamique ci-dessous
        // routage dynamique a revoir
        // switch (array_reverse(explode("/", $url))[1]) {
        //     case 'user':
        //         $user = new UserController();
        //         if (array_reverse(explode("/", $url))[0]=="add") {
        //             $user->addAction();
        //         }elseif(array_reverse(explode("/", $url))[0]=="login"){
        //             $user->loginAction();
        //         }else {
        //             $app = new AppController();
        //             $app->pageNotFound();
        //         }
        //         break;
        //     case 'app':
        //         $app = new AppController();
        //         if (array_reverse(explode("/", $url))[0]=="index") {
        //             $app->indexAction();
        //         }else{
        //             $app->pageNotFound();
        //         }
        //         break;
        //     default:
        //     $app = new AppController();
        //     $app->pageNotFound();
        //         break;
        // }

        //      ||
        //      ||
        //\\\\\\||//////
        // \\\\\\//////
        //  \\\\\/////
        //   \\\\////
        //    \\\///
        //     \\//
        //      \/
        //correction du routage dynamique

        //$route = new Router();
        

    }

}