<?php
namespace MT\PhotoAnalysis;
use \WP_Error as WP_Error;
use \WP_REST_Controller as WP_REST_Controller;
use \WP_REST_Response as WP_REST_Response;

class RestController extends WP_REST_Controller {
	
	const HEADER_CONTENT_TYPE = 'Content-Type';
	const HEADER_CONTENT_TYPE_JSON = 'application/json';
	
	const HTTP_STATUS_200_OK = 200;
	const HTTP_STATUS_201_CREATED = 201;
	const HTTP_STATUS_400_BAD_REQUEST = 400;
	const HTTP_STATUS_405_METHOD_NOT_ALLOWED = 405;
	
	public function register_routes() {
		$namespace = 'mt-wp-photo-analysis/v1';
		register_rest_route($namespace, '/text/(?P<id>\d+)',
			array(
				'methods' => 'PUT',
				'callback' => array($this, 'update_text_item'),
				'args' => array(
					'id' => array(
						'validate_callback' => function($param, $request, $key) {
							return is_numeric($param);
						}
					)
				),
				'permission_callback' => function() {
					return current_user_can('mt_pa_edit_texts');
				}
			)
		);
	}
	
	/**
	 * 
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	*/
	public function update_text_item($request) {
		$contentType = $request->get_header('content-type');
		if (empty($contentType)) {
			return new WP_Error(self::HTTP_STATUS_400_BAD_REQUEST, __('missing content type'));
		}
		if (strtolower($contentType) !== 'application/json') {
			return new WP_Error(self::HTTP_STATUS_400_BAD_REQUEST, __('wrong content type'));
		}
		$body = $request->get_body();
		if (empty($body)) {
			return new WP_Error(self::HTTP_STATUS_400_BAD_REQUEST, __('missing body'));
		}
		$data = 'Hello World';
		return new WP_REST_Response($data, self::HTTP_STATUS_200_OK);
	}
}