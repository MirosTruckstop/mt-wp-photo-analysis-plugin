<?php
use MT\PhotoAnalysis\OptionsPage;

/**
 * Admin menu hook: Add pages to menu.
 */
function mt_pa_admin_menu() {
	add_options_page('Fotoanalyse', 'Fotoanalyse', 'activate_plugins', 'mt-photo-analysis', 'mt_pa_photo_analysis');
}
add_action('admin_menu', 'mt_pa_admin_menu');

/**
 * Page photo search
 */
function mt_pa_photo_analysis() {
	$view = new OptionsPage();
	$view->outputContent();
}
