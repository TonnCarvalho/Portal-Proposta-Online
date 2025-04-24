<?php

namespace MF\Controller;

abstract class Action
{

	protected $view;

	public function __construct()
	{
		$this->view = new \stdClass();
	}

	protected function render($view, $layout = 'layout')
	{
		$this->view->page = $view;

		if (file_exists("../App/Views/" . $layout . ".php")) {
			require_once "../App/Views/" . $layout . ".php";
		} else {
			$this->content();
		}
	}

	protected function content()
	{
		$classAtual = get_class($this);

		// Remove o namespace e o sufixo 'Controller'
		$classAtual = str_replace('App\\Controllers\\', '', $classAtual);
		$classAtual = str_replace('Controller', '', $classAtual);

		// Tenta normalizar com ucfirst, mas sem forçar tudo para minúsculo
		$classAtual = ucfirst($classAtual);
		require_once "../App/Views/" . $classAtual . "/" . $this->view->page . ".php";
	}
}
