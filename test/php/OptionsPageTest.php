<?php
declare(strict_types=1);
namespace MT\PhotoAnalysis;

use PHPUnit\Framework\TestCase;

class OptionsPageTest extends TestCase
{
	
	private function createWpdb($results)
	{
		$wpdb = $this->getMockBuilder('wpdb')
			->setMethods(array('get_results'))
			->getMock();
		$wpdb->method('get_results')
			->willReturn($results);
		return $wpdb;
	}
	
	public function testGetPhotos()
	{
		global $wpdb;
		$wpdb = $this->createWpdb('some response');
		$result = OptionsPage::getPhotos();
		$this->assertEquals('some response', $result);
	}
}
