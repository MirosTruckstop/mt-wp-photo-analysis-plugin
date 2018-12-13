<?php
use MT\PhotoAnalysis\Api\Server;

const API_QUERY_VAR = 'mt_pa_route';

add_action('rest_api_init', function () {
	register_rest_route( 'mt-wp-photo-analysis/v1', '/text', array(
		'methods' => 'POST',
		'callback' => 'mt_pa_callback_text',
		'permission_callback' => function() {
			return current_user_can('mt_pa_edit_texts');
		}
	));
});

function mt_pa_callback_text( $data ) {
	return 'Hello World';
}

function mt_pa_add_api_route() {
	global $wp;
	$wp->add_query_var(API_QUERY_VAR);

	add_rewrite_rule('^'.Server::API_NAMESPACE.'(.*)?','index.php?'.API_QUERY_VAR.'=$matches[1]', 'top');
	flush_rewrite_rules();
}
add_action('init', 'mt_pa_add_api_route');

function mt_pa_api_request() {
	global $wp;
	if (empty($wp->query_vars[API_QUERY_VAR])) {
		return;
	}
	$server = new Server();
	$server->serve_request($wp->query_vars[API_QUERY_VAR]);
	die();
}
add_action('parse_request', 'mt_pa_api_request');
