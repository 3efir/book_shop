<?php
/*
*	working with facade
*	used for index page
*
*/
class IndexController
{
	//stores view obj
	protected $view;
	protected $facade;
	//constructor create view obj
	public function __construct()
	{
		$this -> view = new IndexView();
		$this -> facade = new mainFacade();
		echo FrontController::getLang();
	}
	//used facade for select all books
	//call view index action and sends array
	public function IndexAction()
	{
		$books = $this -> facade -> allBooks();
		$this -> view -> IndexAction($books);
	}
	// called from angular directory for header site
	public function HeaderAction()
	{
		$this -> view -> ShowHeader();
	}
	// called from angular directory for left filters 
	public function MenuAction()
	{
		$authors = $this -> facade -> allAutors();
		$genres = $this -> facade -> allGenres();
		$this -> view -> ShowMenu($authors, $genres);
	}
	public function setLangAction()
	{
		$lang = FrontController::getParams();
		FrontController::setLang($lang);
		$r = $_SERVER['HTTP_REFERER'];
		header('location: '.$r);
	}
}
?>