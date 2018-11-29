<?php

namespace Vendinha\Api\Controllers;

class ErrorController extends ControllerBase {


    public function unauthorizedAction() {
        $response = new \Phalcon\Http\Response();
        $response->setStatusCode(401, "Unauthorized");
        $response->setContentType('application/json')->sendHeaders();
        $response->setContent(json_encode(["success" => false, "msg"=>"Sem Autorização"]));
        return $response;
    }

    public function notFoundAction() {
        $response = new \Phalcon\Http\Response();
        $response->setStatusCode(404, "Unauthorized");
        $response->setContentType('application/json')->sendHeaders();
        $response->setContent(json_encode(["success" => false, "msg"=>"Not Found"]));
        return $response;
    }

}
