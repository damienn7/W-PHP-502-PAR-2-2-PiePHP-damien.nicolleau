<?php

namespace src\Model;

class CommentModel extends \Core\ORM
{

    public function __construct($params=[])
    {
        parent::__construct($params,["has one articles"]);
    }


}