<?php

use Adamgoose\Routing\Annotations\Scanner;
use Mockery as m;

class RoutingAnnotationScannerTest extends PHPUnit_Framework_TestCase {

	public function testProperRouteDefinitionsAreGenerated()
	{
		require_once __DIR__.'/fixtures/annotations/BasicController.php';

		with(new Adamgoose\AnnotationsServiceProvider(m::mock('Illuminate\Contracts\Foundation\Application')))
			->setUpAnnotationRegistries();

		$scanner = Scanner::create(['App\Http\Controllers\BasicController']);
		$definition = str_replace(PHP_EOL, "\n", $scanner->getRouteDefinitions());

		$this->assertEquals(trim(file_get_contents(__DIR__.'/results/annotation-basic.php')), $definition);
	}

	public function tearDown()
	{
		m::close();
	}

}
