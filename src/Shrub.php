<?php namespace Shrub;
use \Twig_Loader_Filesystem;
use \Twig_Environment;
use \Exception;

class Shrub {
	private $_loader;
	private $_twig;
	private $_context;
	private $_templateDir;
	private $_templateName;
	private $_template;

	function __construct(string $templateDir = "") {
		if ($templateDir == "") {
			$templateDir = dirname((debug_backtrace())[0]['file']);
		}

		// Base directory
		$templateDir = rtrim($templateDir, '/');
		$this->_loader = new Twig_Loader_Filesystem($templateDir);
		$templateDir .= '/';

		$this->_templateDir = $templateDir;
		
		// Pages
		$this->addPath($templateDir . "pages");
		// Blocks
		$this->addPath($templateDir . "blocks", "block");
		// Macros
		$this->addPath($templateDir . "macros", "macro");
		// Views
		$this->addPath($templateDir . "views", "view");

		$this->_context = [];
	}

	public function addPath(string $dirpath, string $namespace = "") : void
	{
		// Check directory
		if (file_exists($dirpath)) {
			if ($namespace == "") {
				$this->_loader->addPath($dirpath);
			} else {
				$this->_loader->addPath($dirpath, $namespace);
			}			
			// Re-initialize enviroment
			$this->_twig = new Twig_Environment($this->_loader, array('debug' => true));
		} else {
			// throw new Exception("$dirpath Directory does not exist", 1);			
		}
	}

	public function setTemplate (string $template) : void
	{
		// Sanitize: remove .twig
		$this->_templateName = static::SanitizeFile($template);
		$this->_template = $this->_twig->load("{$this->_templateName}.twig");
	}

	public function addContext (mixed $context, mixed $value = NULL) : void
	{
		if (is_array($context)) {
			$this->_context = array_replace_recursive($this->_context, $context);
		} else {
			// TODO: check if context is string OR converto to string
			$this->_context[$context] = $value;
		}
	}

	public function getPHP() : string
	{
		return static::SanitizeFile($this->_templateDir . "pages/" . $this->_templateName) . ".php";
	}

	public function render() : void
	{
		echo $this->_template->render($this->_context);
	}

	private static function SanitizeFile(string $filename) : string
	{
		return preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
	}
}