<?php
declare(strict_types=1);
namespace MT\PhotoAnalysis;
use PHPUnit\Framework\TestCase;


class SetupTest extends TestCase {
	
	private function __createWpdb() {
		$wpdb = $this->getMockBuilder('wpdb')
				->setMethods(array('get_charset_collate'))
				->getMock();
		$wpdb->prefix = 'wp_';
		$wpdb->method('get_charset_collate')
			->willReturn('charset');
		return $wpdb;
	}
	
	public function testSqlCreateTable() {
		global $wpdb;
		$wpdb = $this->__createWpdb();
		
		$actual = Setup::sqlCreateTable();
		$expected = "CREATE TABLE `wp_mt_pa_photo_text` (
			`photo_id` smallint(4) unsigned NOT NULL,
			`text` varchar(60),
			INDEX `text_index` (`text`),
			UNIQUE (`photo_id`, `text`)
		) charset;";
		$this->assertEquals($expected, $actual);
	}
	
	public function testSqlDropTable() {
		global $wpdb;
		$wpdb = $this->__createWpdb();
		
		$actual = Setup::sqlDropTable();
		$expected = "DROP TABLE IF EXISTS `wp_mt_pa_photo_text`";
		$this->assertEquals($expected, $actual);
	}
}