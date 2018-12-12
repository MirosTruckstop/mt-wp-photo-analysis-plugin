<?php
use MT\PhotoAnalysis\Api\Server;

const API_QUERY_VAR = 'mt_pa_route';

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
