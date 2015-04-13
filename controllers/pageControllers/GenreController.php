<?php
class GenreController
{
	//stores view obj
	protected $view;
	protected $facade;
	//constructor create view obj
	public function __construct()
	{
		$this -> view = new IndexView();
		$this -> facade = new mainFacade();
		return true;
	}
// call facade for select books by selected genre
	public function ShowAction()
	{
		$id = FrontController::getParams();
		$books = $this -> facade -> getBooksByGenre($id);
		$this -> view -> IndexAction($books);
		return true;
	}
}
?>