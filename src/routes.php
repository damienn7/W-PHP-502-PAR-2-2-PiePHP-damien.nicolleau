<?php

// routage statique
//Core\Router::connect('/', ['controller'=>'app','action'=>'index']);
Core\Router::connect('/register', ['controller'=>'user','action'=>'add']);
Core\Router::connect('/test', ['controller'=>'user','orm'=>'test']);
Core\Router::connect('/user/{id:integer}', ['controller'=> 'user' ,'action'=>'show']);

