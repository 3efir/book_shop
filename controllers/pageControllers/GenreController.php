<?php
/*
*	working with facade
*	used for index page
*	
*/
class GenreController
{
	//stores view obj
	protected $view;
	protected $facade;
	//constructor create view obj
	public function __construct()
	{
		$this -> view = new ListView();
		$this -> facade = new mainFacade();
	}
	public function ShowAction()
	{
		$id = FrontController::getParams();
		$books = $this -> facade -> getBooksByGenre($id);
		$indexView = new IndexView();
		$indexView -> IndexAction($books);
	}
}
?>
