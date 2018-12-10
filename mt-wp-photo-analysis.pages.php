<?php
/**
 * Type edit
 */
const TYPE_EDIT = 'edit';

/**
 * Admin menu hook: Add pages to menu.
 */
function mt_pa_admin_menu() {

	//add_menu_page('MT Verwaltung', 'MT Verwaltung', 'edit_others_pages', 'mt-news', null, 'dashicons-hammer', 4);
	//add_submenu_page('mt-news', 'Fotoanalyse', 'Fotoanalyse', 'activate_plugins', 'mt-photo-analysis', 'mt_pa_photo_analysis');
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