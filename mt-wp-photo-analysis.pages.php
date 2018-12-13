<?php
use MT\PhotoAnalysis\OptionsPage;

add_action('admin_menu', function() {
	# Add pages to menue
	add_options_page(__('Fotoanalyse'), __('Fotoanalyse'), 'activate_plugins', 'mt-photo-analysis', 'mt_pa_photo_analysis');
});

/**
 * Page photo search
 */
function mt_pa_photo_analysis() {
	$view = new OptionsPage();
	$view->outputContent();
}
