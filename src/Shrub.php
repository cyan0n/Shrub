<?php namespace Shrub;
use \Twig_Loader_Filesystem;
use \Twig_Environment;
class Shrub {
	private $_twig;
	private $_context;
	private $_template;

	function __construct(string $templateDir) {
		$loader = new Twig_Loader_Filesystem($templateDir);
		// Base directory
		// Blocks
		// Macros
		// Views
		// Pages
	}
	public function test($bool = true)
	{
		print_r(debug_backtrace());
		return;
		$loader = new Twig_Loader_Filesystem(__DIR__);
		$loader->addPath(__DIR__);
		$twig = new Twig_Environment($loader, array('debug' => true));
	}
}