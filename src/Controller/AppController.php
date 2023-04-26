<?php

namespace src\Controller;

class AppController extends \Core\Controller
{

    private $request;

    public function __construct(){
        $this->request = new \Core\Request();
    }
    public function indexAction()
    {
        //retourne la page index de l'application
        //require '/var/www/mvc.fr/src/View/App/index.php';
        $this->render("index");
    }

    public function pageNotFound()
    {
        //retourne la page d'erreur 404 - Not found
        require '/var/www/mvc.fr/src/View/Error/404.php';
    }


}