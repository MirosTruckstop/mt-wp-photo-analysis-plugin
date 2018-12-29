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
use MT\PhotoAnalysis\RestController;

define('MT_PA_NAME', dirname(plugin_basename( __FILE__ )));

register_activation_hook(__FILE__, function() {
	# Register a custom role and cap for the REST API
	add_role('mt_pa_editor', __('MT Photo Analysis Editor'));
	$role = get_role('mt_pa_editor');
	$role->add_cap('mt_pa_edit_texts');
});


register_deactivation_hook(__FILE__, function() {
	# Remove the custom cap and role for the REST API
	$role = get_role('mt_pa_editor');
	if ($role) {
		$role->remove_cap('mt_pa_edit_texts');
		remove_role('mt_pa_editor');
	}
	# Remove the settings
	unregister_setting(MT_PA_NAME, 'mt_pa_queue_topic');
});

add_action('rest_api_init', function() {
	$controller = new RestController();
	$controller->register_routes();
});

add_action('admin_init', function() {
	register_setting(MT_PA_NAME, 'mt_pa_queue_topic');
	if (!get_option('mt_pa_queue_topic')) {
		update_option('mt_pa_queue_topic', 'photo-analysis-request');
	}
});

add_action('admin_menu', function() {
	add_options_page(__('Fotoanalyse'), __('Fotoanalyse'), 'activate_plugins', 'mt-photo-analysis', function() {
		$view = new OptionsPage();
		$view->outputContent();
	});
});
