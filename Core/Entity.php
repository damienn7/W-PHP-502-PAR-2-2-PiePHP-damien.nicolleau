<?php

namespace Core;

class Entity extends ORM{

    public function __construct($params,$rel){
        parent::__construct($params,$rel);
    }
}