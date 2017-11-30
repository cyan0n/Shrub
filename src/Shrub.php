<?php namespace Shrub;
use \Twig_Loader_Filesystem;
use \Twig_Environment;
class Shrub {
	private $_loader;
	private $_twig;
	private $_context;
	private $_template;

	function __construct(string $templateDir = "") {
		if ($templateDir == "") {
			$templateDir = dirname((debug_backtrace())[0]['file']);
		}
		// Base directory
		$templateDir = rtrim($templateDir, '/');
		$this->_loader = new Twig_Loader_Filesystem($templateDir);
		$templateDir .= '/';
		// Pages
		$this->addPath($templateDir . "pages");
		// Blocks
		$this->addPath($templateDir . "blocks", "block");
		// Macros
		$this->addPath($templateDir . "macros", "macro");
		// Views
		$this->addPath($templateDir . "views", "view");

		$this->_twig = new Twig_Environment($this->_loader, array('debug' => true));
	}

	public function addPath(string $dirpath, string $namespace = "") : void
	{
		// Check directory
		if (file_exists($dirpath)) {
			$this->_loader->addPath($dirpath, $namespace);
		}
	}
}