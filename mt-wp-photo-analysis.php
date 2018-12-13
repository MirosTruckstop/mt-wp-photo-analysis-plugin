<?php
/*
Plugin Name: MT Photo Analysis
Plugin URI: https://github.com/MirosTruckstop/mt-wp-photo-analysis-plugin
Description: Wordpress photo analysis plugin for MiRo's Truckstop
Version: 0.1.0
Author: Xennis
Text Domain: mt-wp-photo-analysis
*/

/**
 * Plugin name
 */
define('MT_PA_NAME', dirname(plugin_basename( __FILE__ )));
/**
 * Plugin directory
 */
define('MT_PA_DIR', WP_PLUGIN_DIR.'/'.MT_PA_NAME);
/**
 * PHP source directory
 */
define('MT_PA_DIR_SRC_PHP', MT_PA_DIR.'/src/php');


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
});


require_once(MT_PA_DIR.'/vendor/autoload.php');
require_once(MT_PA_DIR.'/mt-wp-photo-analysis.pages.php');
require_once(MT_PA_DIR.'/mt-wp-photo-analysis.routing.php');