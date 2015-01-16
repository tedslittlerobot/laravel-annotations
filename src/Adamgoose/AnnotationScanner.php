<?php namespace Adamgoose;

use ReflectionClass;
use Symfony\Component\Finder\Finder;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\SimpleAnnotationReader;

class AnnotationScanner {

	/**
	 * The path to scan for annotations.
	 *
	 * @var array
	 */
	protected $scan;

	/**
	 * The namespaces of the annotations to use
	 *
	 * @var array
	 */
	public $namespaces = [];

	/**
	 * Create a new scanner instance.
	 *
	 * @param  array  $scan
	 * @return void
	 */
	public function __construct(array $scan)
	{
		$this->scan = $scan;
	}

	/**
	 * Create a new scanner instance.
	 *
	 * @param  array  $scan
	 * @return static
	 */
	public static function create(array $scan)
	{
		return new static($scan);
	}

	/**
	 * Get all of the ReflectionClass instances in the scan array.
	 *
	 * @return array
	 */
	protected function getClassesToScan()
	{
		$classes = [];

		foreach ($this->scan as $scan)
		{
			try
			{
				$classes[] = new ReflectionClass($scan);
			}
			catch (Exception $e)
			{
				//
			}
		}

		return $classes;
	}

	/**
	 * Add an annotation namespace for the SimpleAnnotationReader instance
	 *
	 * @param string $namespace
	 */
	public function addAnnotationNamespace($namespace)
	{
		$this->namespaces[] = $namespace;

		return $this;
	}

	/**
	 * Get an annotation reader instance.
	 *
	 * @return \Doctrine\Common\Annotations\SimpleAnnotationReader
	 */
	protected function getReader()
	{
		$reader = new SimpleAnnotationReader;

		foreach ($this->namespaces as $namespace)
			$reader->addNamespace($namespace);

		return $reader;
	}

}
