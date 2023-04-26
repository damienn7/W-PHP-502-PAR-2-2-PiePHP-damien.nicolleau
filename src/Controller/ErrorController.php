<?php

namespace src\Controller;

class ErrorController extends \Core\Controller
{

    public function pageNotFound()
    {
        //retourne la page d'erreur 404 - Not found
        $this->render("404");
    }
}