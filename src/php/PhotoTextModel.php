<?php
namespace MT\PhotoAnalysis;

class PhotoTextModel {
	
	const PHOTO_ID_LENGTH = 4;
	const TEXT_LENGTH = 60;
	
	private static function getTable() {
		global $wpdb;
		return $wpdb->prefix.'mt_pa_photo_text';
	}
	
	public static function sqlCreateTable() {
		global $wpdb;
		$table_name = self::getTable();
		$charset_collate = $wpdb->get_charset_collate();

		return "CREATE TABLE `$table_name` (
			`photo_id` smallint(".self::PHOTO_ID_LENGTH.") unsigned NOT NULL,
			`text` varchar(".self::TEXT_LENGTH."),
			INDEX `text_index` (`text`),
			UNIQUE (`photo_id`, `text`)
		) $charset_collate;";
	}
	
	public static function sqlDropTable() {
		return "DROP TABLE IF EXISTS `".self::getTable()."`";
	}
	
	public static function delete($id) {
		global $wpdb;
		return $wpdb->delete(self::getTable(), array('photo_id' => $id), array('%d'));
	}
	
	public static function insert($id, $text) {
		global $wpdb;
		return $wpdb->insert(self::getTable(), array(
			'photo_id' => $id,
			'text' => $text
		), array(
			'%d',
			'%s'
		));
	}
}
