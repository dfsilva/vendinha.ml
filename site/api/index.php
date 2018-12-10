<?php

use Phalcon\Mvc\Micro;

require __DIR__ . "/config/services.php";


$app = new Micro($di);
$app->before(new CORSMiddleware());
$app->setEventsManager($eventsManager);


$app->get(
    "/",
    function () {
        echo "<h1>Welcome!</h1>";
    }
);

$app->get(
    "/api/get-local/{lat}/{lon}",
    function ($lat, $lon) use ($app) {

        $postData = [
            "from" => 0, "size" => 1,
            "sort" => [
                [
                    "_geo_distance" => [
                        "localizacao" => [
                            "lat" => $lat,
                            "lon" => $lon
                        ],
                        "order" => "asc",
                        "unit" => "km",
                        "distance_type" => "plane"
                    ]
                ]
            ]
        ];

        //$app->getDI()->get('log')->info(json_encode($postData));

        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'content' => json_encode($postData)
            ],
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ]
        ]);

        $response = file_get_contents('https://search-tiger-strips-4fbdu7i2q6p7uhsxyaecyzqhbu.sa-east-1.es.amazonaws.com/enderecos/_search', FALSE, $context);

        //$app->getDI()->get('log')->info($response);

        //Utils::retornarSucesso($response);
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
