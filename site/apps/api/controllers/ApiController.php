<?php

namespace Vendinha\Api\Controllers;


class ApiController extends ControllerBase
{

    public function testAction() {
        $response = new \Phalcon\Http\Response();
//        $response->setStatusCode(401, "Unauthorized");
        $response->setContentType('application/json')->sendHeaders();
        $response->setContent(json_encode(array("success" => false, "msg"=>"Sem Autorização")));
        return $response;
    }

}