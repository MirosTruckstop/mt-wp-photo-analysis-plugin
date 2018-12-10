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

require_once(MT_PA_DIR.'/mt-wp-photo-analysis.pages.php');