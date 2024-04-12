<?php

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use src\MyApp\Chat;

require dirname(__DIR__) . '/sofien_el-bahi_jeu/vendor/autoload.php';



$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new \Texas\TexasGame\TexasGame()
        )
    ),
    8080
);


$server->run();
