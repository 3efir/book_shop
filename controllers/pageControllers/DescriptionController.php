<?php
class DescriptionController
{
	//stores view obj
	protected $view;
	protected $facade;
	//constructor create view obj
	public function __construct()
	{
		$this -> view = new DescView();
		$this -> facade = new mainFacade();
	}
	public function indexAction()
	{
		$id = FrontController::getParams();
		$book = $this -> facade -> getBook($id);
		$this -> view -> IndexAction($book);
	}
}


?>