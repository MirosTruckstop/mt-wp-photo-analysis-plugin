<?php
namespace MT\PhotoAnalysis;

class Setup {
	
	public static function sqlCreateTable() {
		global $wpdb;
		$table_name = $wpdb->prefix.'mt_pa_photo_text';
		$charset_collate = $wpdb->get_charset_collate();

		return "CREATE TABLE `$table_name` (
			`photo_id` smallint(4) unsigned NOT NULL,
			`text` varchar(60),
			INDEX `text_index` (`text`),
			UNIQUE (`photo_id`, `text`)
		) $charset_collate;";
	}
	
	public static function sqlDropTable() {
		global $wpdb;
		$table_name = $wpdb->prefix.'mt_pa_photo_text';
		return "DROP TABLE IF EXISTS `$table_name`";
	}
}
