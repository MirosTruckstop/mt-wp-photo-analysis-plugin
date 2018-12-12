<?php

namespace MT\PhotoAnalysis\Api;

class Server {
	
	const API_NAMESPACE = 'mt/pa/api/';
	
	const HEADER_CONTENT_TYPE = 'Content-Type';
	const HEADER_CONTENT_TYPE_JSON = 'application/json';
	
	const HTTP_STATUS_200_OK = 200;
	const HTTP_STATUS_201_CREATED = 201;
	const HTTP_STATUS_400_BAD_REQUEST = 400;
	const HTTP_STATUS_405_METHOD_NOT_ALLOWED = 405;
	
	public function serve_request($route=null) {
		#$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_ENCODED);
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method != 'PUT') {
			$this->json_response(self::HTTP_STATUS_405_METHOD_NOT_ALLOWED, 'Method not allowed');
			die();
		}
		$contentType = $_SERVER['CONTENT_TYPE'];
		if ($contentType != self::HEADER_CONTENT_TYPE_JSON) {
			$this->json_response(self::HTTP_STATUS_400_BAD_REQUEST, "Bad request");
			die();
		}
		
		$body = json_decode(file_get_contents("php://input"), TRUE);
		if (empty($body)) {
			$this->json_response(self::HTTP_STATUS_400_BAD_REQUEST, 'Bad request');
			die();
		}
		$this->json_response(self::HTTP_STATUS_200_OK, 'Ok');
	}
	
	private function json_response($code, $message) {
			http_response_code($code);
			echo '{"code": '.$code.', "message": "'.$message.'"}';
	}
}