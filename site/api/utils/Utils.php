<?php

class Utils {

    public static function retornarSucesso($retorno){

		$response = new \Phalcon\Http\Response ();
		$response->setContentType ( 'application/json' )->sendHeaders ();
			
		$response->setContent ( json_encode ( [
				"success" => true,
				"result" => $retorno 
		] ) );

		return $response;
	}

	public static function retornarErro($msg){
		$response = new \Phalcon\Http\Response ();
			$response->setStatusCode ( 502, "Bad Gateway" )->sendHeaders ();
			$response->setContentType ( 'application/json' )->sendHeaders ();
			$response->setContent ( json_encode ( array (
					"success" => false,
					"msg" => $msg
			) ) );
			return $response;
	}

	public static function retornar404(){
		$response = new \Phalcon\Http\Response ();
		$response->setStatusCode ( 404, "Not found" )->sendHeaders ();
		$response->setContentType ( 'application/json' )->sendHeaders ();
		return $response;
	}
}

