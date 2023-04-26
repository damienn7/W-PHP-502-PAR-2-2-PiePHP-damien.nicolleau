<?php

namespace src\Model;

class ArticleModel extends \Core\ORM
{
    public function __construct($params=[])
    {
        parent::__construct($params,["has many commentaires","has many tags"]);
    }
}