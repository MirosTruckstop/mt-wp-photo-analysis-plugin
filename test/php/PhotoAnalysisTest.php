<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class PhotoAnalysisTest extends TestCase {
	
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
		$result = MT_Admin_View_PhotoAnaysis::__getPhotos();
		$this->assertEquals($result, 'some response');
	}
}