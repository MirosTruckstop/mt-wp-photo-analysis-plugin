<?php
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
	require_once(MT_PA_DIR.'/vendor/autoload.php');
	require_once(MT_PA_DIR_SRC_PHP.'/PhotoAnaysis.php');

	$view = new MT_Admin_View_PhotoAnaysis();
	$view->outputContent();
}