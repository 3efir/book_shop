<?php
/*
*	working with facade
*	used for show authors list
*	and books by id author
*/
class AutorController
{
	//stores view obj
	protected $view;
	//stores facade obj
	protected $facade;
	//constructor create view and facade obj
	public function __construct()
	{
		$this -> view = new ListView();
		$this -> facade = new mainFacade();
	}
	//select books by id author 
	//then create obj IndexView and send array
	public function ShowAction()
	{
		$id = FrontController::getParams();
		$books = $this -> facade -> getBooksByAutor($id);
		$indexView = new IndexView();
		$indexView -> IndexAction($books);
	}
}
?>