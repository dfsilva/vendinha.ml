<?php

use Phalcon\Mvc\Micro;

require __DIR__ . "/config/services.php";

$app = new Micro($di);


$app->get(
    "/",
    function () {
        echo "<h1>Welcome!</h1>";
    }
);

$app->get(
    "/api/test",
    function () use ($app) {

        $app->getDI()->get('log')->info('/api/test ');
        echo "<h1>Hello!</h1>";
        echo "Your IP Address is ", $app->request->getClientAddress();
    }
);

$app->post(
    "/api/store/something",
    function () use ($app) {
        $name = $app->request->getPost("name");
        echo "<h1>Hello! $name</h1>";
    }
);

$app->notFound(
    function () use ($app) {
        $app->response->setStatusCode(404, "Not Found");
        $app->response->sendHeaders();
        echo "This is crazy, but this page was not found!";
    }
);

$app->handle();
