<?php namespace Shrub;
use \Twig_Loader_Filesystem;
use \Twig_Environment;
class Shrub {
	private $_twig;
	private $_context;
	private $_template;

	function __construct(string $templateDir = "") {
		if ($templateDir == "") {
			$templateDir = dirname((debug_backtrace())[0]['file']);
		}
		// Base directory
		$templateDir = rtrim($templateDir, '/');
		$loader = new Twig_Loader_Filesystem($templateDir);
		$templateDir .= '/';
		// Pages
		$loader->addPath($templateDir . "pages");
		// Blocks
		$loader->addPath($templateDir . "blocks", "block");
		// Macros
		$loader->addPath($templateDir . "macros", "macro");
		// Views
		$loader->addPath($templateDir . "views", "view");

		$this->_twig = new Twig_Environment($loader, array('debug' => true));
	}
}