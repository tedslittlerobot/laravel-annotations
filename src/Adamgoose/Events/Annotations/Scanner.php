<?php namespace Adamgoose\Events\Annotations;

use Adamgoose\AnnotationScanner;

class Scanner extends AnnotationScanner {

	/**
	 * The namespace to check for annotation reader annotations
	 *
	 * @var string
	 */
	protected $namespace = 'Adamgoose\Events\Annotations\Annotations';

	/**
	 * Convert the scanned annotations into route definitions.
	 *
	 * @return string
	 */
	public function getEventDefinitions()
	{
		$output = '';

		$reader = $this->getReader();

		foreach ($this->getClassesToScan() as $class)
		{
			foreach ($class->getMethods() as $method)
			{
				foreach ($reader->getMethodAnnotations($method) as $annotation)
				{
					$output .= $this->buildListener($class->name, $method->name, $annotation->events);
				}
			}
		}

		return trim($output);
	}

	/**
	 * Build the event listener for the class and method.
	 *
	 * @param  string  $class
	 * @param  string  $method
	 * @param  array  $events
	 * @return string
	 */
	protected function buildListener($class, $method, $events)
	{
		return sprintf('$events->listen(%s, \''.$class.'@'.$method.'\');', var_export($events, true)).PHP_EOL;
	}

}
