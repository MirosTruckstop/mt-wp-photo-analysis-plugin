<?php
declare(strict_types=1);
namespace MT\PhotoAnalysis;
use PHPUnit\Framework\TestCase;

class OptionsPageTest extends TestCase {
	
	private function __createWpdb($results) {
		$wpdb = $this->getMockBuilder('wpdb')
				->setMethods(array('get_results'))
				->getMock();
		$wpdb->method('get_results')
			 ->willReturn($results);
		return $wpdb;
	}
	
	public function testGetPhotos() {
		global $wpdb;
		$wpdb = $this->__createWpdb('some response');
		$result = OptionsPage::__getPhotos();
		$this->assertEquals('some response', $result);
	}
}