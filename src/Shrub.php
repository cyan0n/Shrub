<?php namespace Shrub;

class Shrub {
	public function test($bool = true)
	{
		$loader = new Twig_Loader_Filesystem(__DIR__);
		$loader->addPath(__DIR__);
		$twig = new Twig_Environment($loader, array('debug' => true));
	}
}