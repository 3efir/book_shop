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
		return true;
	}
// call facade for select info about selected book
// send info to view for display
	public function indexAction()
	{
		$id = FrontController::getParams();
		$book = $this -> facade -> getBook($id);
		$this -> view -> IndexAction($book);
		return true;
	}
}
?>