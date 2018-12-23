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
	const HTTP_STATUS_404_NOT_FOUND = 404;
	const HTTP_STATUS_500_INTERNAL_ERROR = 500;
	
	public function register_routes() {
		$namespace = 'mt-wp-photo-analysis/v1';
		register_rest_route($namespace, '/text/(?P<id>\d+)',
			array(
				'methods' => 'PUT',
				'callback' => array($this, 'update_text_item'),
				'args' => array(
					'id' => array(
						'validate_callback' => function($param, $request, $key) {
							return is_numeric($param) && strlen($param) <= 4; # db field length
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
		$id = (int) $request['id']; # guaranteed by validate_callback
		$data = json_decode($body);
		if (!property_exists($data, 'textAnnotations')) {
			return new WP_Error(self::HTTP_STATUS_400_BAD_REQUEST, __('invalid body'));
		}
		$textAnnotations = $data->textAnnotations;
		if (!is_string($textAnnotations) ||
				strlen($textAnnotations) == 0 ||
				strlen($textAnnotations) > 500) { # db field limit
			return new WP_Error(self::HTTP_STATUS_400_BAD_REQUEST, __('invalid body'));
		}
		return $this->__update_text_annotations($id, $textAnnotations);
	}
	
	private function __update_text_annotations($id, $textAnnotations) {
		global $wpdb;
		$tableName = $wpdb->prefix.'mt_photo';
		$photo = $wpdb->get_row("SELECT `id`, `description` FROM $tableName WHERE id = $id");
		if (!$photo) {
			return new WP_Error(self::HTTP_STATUS_404_NOT_FOUND, __('unknown id'));
		}
		$searchText = $photo->description.' '.$textAnnotations;
		$searchText = strlen($searchText) > 1000 ? substr($searchText, 0, 999) : $searchText;
		$result = $wpdb->update(
			$tableName,
			array(
				'detected_text' => $textAnnotations,
				'search_text' => $searchText
			),
			array('id' => $id),
			array('%s', '%s'),
			array('%d')
		);
		if (!$result) {
			return new WP_Error(self::HTTP_STATUS_500_INTERNAL_ERROR, __('update error'));
		}
		return new WP_REST_Response("OK", self::HTTP_STATUS_200_OK);
	}
}