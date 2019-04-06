<?php
class IndexView {
	public $model;
	public function __construct() {
		$this->model = new IndexModel();
	}
	public function generateIndexView($connectionDb, $template, $pathToPage, $contentOfPage) { 
		require_once __DIR__ . '/Template/'. $template . '.php';
	}
}