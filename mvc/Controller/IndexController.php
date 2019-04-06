<?php
class IndexController {
	public $model;
	public $view;
	public function __construct() {
		$this->model = new IndexModel();
		$this->view = new IndexView();
	}
	public function indexAction($connectionDb, $pathToPage, $contentOfPage) { 

		if ($this->model->getId() !== null) {
			$this->model->goToLink($connectionDb);
		} else {
			if (isset($_POST['longLink'])) {
				$this->model->shortenLink($connectionDb);
			} else {
				$this->view->generateIndexView($connectionDb, 'template', $pathToPage, $contentOfPage); 
			}
		}
	}
	
}