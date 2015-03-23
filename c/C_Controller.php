<?php

abstract class C_Controller
{

	protected $params;
	protected $title;		// заголовок страницы
	protected $content;		// содержание страницы
	protected $layout;		// содержание страницы


	public function __construct()
	{
		$this->layout= BASE_LAYOUT;
		$this->title = TITLE;
	}


	public function Request($action, $params)
	{
		$this->params = $params;
		$this->$action();
	}

	//
	// Запрос произведен методом GET?
	//
	protected function IsGet()
	{
		return $_SERVER['REQUEST_METHOD'] == 'GET';
	}

	//
	// Запрос произведен методом POST?
	//
	protected function IsPost()
	{
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}

	//
	// Генерация HTML шаблона в строку.
	//
	protected function Template($fileName, $vars = array())
	{
		// Установка переменных для шаблона.
		foreach ($vars as $k => $v)
		{
			$$k = $v;
		}

		// Генерация HTML в строку.
		ob_start();
		include "$fileName";
		return ob_get_clean();
	}

	// Если вызвали метод, которого нет - завершаем работу
	public function __call($name, $params){
		die('Не пишите фигню в url-адресе!!!');
	}

	// 
	protected function redirect($url){

		if($url[0] == '/')
			$url = BASE_URL . substr($url, 1);

		header("location: $url");
		exit();
	}

	public function render($fileName, $vars = array())
	{
		$this->content = $this->Template($fileName,$vars);
		$varsmain = array('title' => $this->title, 'content' => $this->content);
		$page = $this->Template($this->layout, $varsmain);
		echo $page;
	}

}
