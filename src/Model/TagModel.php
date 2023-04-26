<?php

namespace src\Model;

class TagModel extends \Core\ORM
{

    public function __construct($params=[])
    {
        parent::__construct($params,["has many articles"]);
    }

    
}