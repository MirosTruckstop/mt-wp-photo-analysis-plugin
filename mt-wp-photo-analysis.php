<?php
/*
Plugin Name: MT Photo Analysis
Plugin URI: https://github.com/MirosTruckstop/mt-wp-photo-analysis-plugin
Description: Wordpress photo analysis plugin for MiRo's Truckstop
Version: 0.1.0
Author: Xennis
Text Domain: mt-wp-photo-analysis
*/
require_once(plugin_dir_path(__FILE__).'/vendor/autoload.php');
use MT\PhotoAnalysis\OptionsPage;
use MT\PhotoAnalysis\PhotoTextModel;
use MT\PhotoAnalysis\RestController;

register_activation_hook(__FILE__, function() {
	# Register a custom role and cap for the REST API
	add_role('mt_pa_editor', __('MT Photo Analysis Editor'));
	$role = get_role('mt_pa_editor');
	$role->add_cap('mt_pa_edit_texts');
	
	# Create the database table to store the photo texts
	require_once(ABSPATH.'wp-admin/includes/upgrade.php');
	dbDelta(PhotoTextModel::sqlCreateTable());
});


register_deactivation_hook(__FILE__, function() {
	# Remove the custom cap and role for the REST API
	$role = get_role('mt_pa_editor');
	if ($role) {
		$role->remove_cap('mt_pa_edit_texts');
		remove_role('mt_pa_editor');
	}
	
	# Drop the database table
	global $wpdb;
	$wpdb->query(PhotoTextModel::sqlDropTable());
});

add_action('rest_api_init', function () {
	$controller = new RestController();
	$controller->register_routes();
});

add_action('admin_menu', function() {
	add_options_page(__('Fotoanalyse'), __('Fotoanalyse'), 'activate_plugins', 'mt-photo-analysis', function() {
		$view = new OptionsPage();
		$view->outputContent();
	});
});
