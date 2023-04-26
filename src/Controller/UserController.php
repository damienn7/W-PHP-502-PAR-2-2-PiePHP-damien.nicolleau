<?php

namespace src\Controller;

use src\Model\CommentModel;
use src\Model\UserModel;
use src\Model\ArticleModel;
use src\Model\TagModel;

class UserController extends \Core\Controller
{
    private $request;

    public function __construct()
    {
        $this->request = new \Core\Request();
    }
    public function addAction()
    {
        $this->render("register");

    }

    public function loginAction()
    {
        $this->render("login");
    }

    public function showAction($id=""){
        $scope = [];
        $user = new UserModel();
        $where = "id = ".$id;
        $scope = $user->find("users",array('WHERE' => $where, 'ORDER BY' => 'id ASC', 'LIMIT' => ''));
        print_r($scope);
        $this->render("show",compact("scope",$scope));
    }

    public function connectAction()
    {
        //calling request class to secure the data (post or get)
        $post = $this->request->post("submit_login");

        if (!empty($post["email"]) && !empty($post["password"])) {
            $user = new UserModel($post);
            $where = "email='" . $post["email"] . "'";
            $user_returned = $user->find("user", array('WHERE' => $where, 'ORDER BY' => 'id ASC', 'LIMIT' => ''));
            if (is_array($user_returned)) {
                session_start();
                $_SESSION["id"] = $user_returned[0]["id"];
                $_SESSION["email"] = $user_returned[0]["email"];
                $this->render("index");
            } else {
                $app = new AppController();
                $action = "pageNotFound";
                $app->$action();
            }
        }
    }

    public function registerAction()
    {
        //calling request class to secure the data (post or get)
        $post = $this->request->post("submit_register");
        //calling UserModel
        $user = new UserModel($post);
        //calling the model function for storing user to bdd
        $user->create("users", ["email" => $post["email"], "password" => $post["password"]]);

        $this->render("index");
    }

    public function testOrm()
    {
        // $orm = new \Core\ORM();
        //$orm->create('tags', array('tag' => "un  super  tag", 'article_id' => 1));
        // $orm->create('articles', array('titre' => "un  super  titre", 'content' => 'et voici  une  super  article  de blog', 'author' => 'Rodrigue'));
        // $orm->create('articles', array('titre' => "un  super  titre", 'content' => 'et voici  une  super  article  de blog', 'author' => 'Rodrigue'));
        // $orm->create('articles', array('titre' => "un  super  titre", 'content' => 'et voici  une  super  article  de blog', 'author' => 'Rodrigue'));
        //$orm->update('articles', 1, array('titre' => "un  super  titre", 'content' => 'et voici  un  super  article  de blog', 'author' => 'Rodrigue'));
        // $orm->delete('articles', 5);
        // $orm->delete('articles', 2);
        // $orm->delete('articles', 3);
        // $orm->delete('articles', 4);
        // $orm->resetAutoIncrement("articles");
        // $orm->resetAutoIncrement("commentaires");
        // $orm->create('commentaires', array('content' => "un  super  commentaire", 'article_id' => 1));
        echo "<br>";
        echo "<br>";
        echo "hello ORM tester";
        // $article = new ArticleModel();
        // var_dump($article->read("articles", 1));
        // echo "<br>";
        // echo "<br>";
        // $tag = new TagModel();
        // var_dump($tag->read("articles_tags", 1,"tags"));
    }
}