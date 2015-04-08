<?php 
session_start();
class IndexView
{
	//htmlHelper obj
	protected $htmlHelper;
	//create htmlHelper obj
	public function __construct()
	{
		$this -> htmlHelper = new htmlHelper();
	}
	// rendering body
	// $arr - array with data from DB 
	public function IndexAction($arr)
	{
		//class for div
		$class = "col-md-3";
		$div = $this -> htmlHelper -> allBooks($arr, $class);
		//second param - echo $test in template
		$view = FrontController::render('../resources/templates/index.html', $div);
		FrontController::setBody($view);
		return true;
	}
	// rendering header
	public function ShowHeader()
	{
		if(!$_SESSION['id'])
		{
			//$url = "<a href='/book_shop/login'>Вход</a>";
			$url = $this -> htmlHelper -> getLogin();
			$view = FrontController::render('../resources/templates/header.html',$url);
			FrontController::setBody($view);
			return true;
		}
		else
		{
			$url = $this -> htmlHelper -> getProfileLinks($_SESSION['id'], $_SESSION['user']);
			$view = FrontController::render('../resources/templates/header.html',$url);
			FrontController::setBody($view);
			return true;
		}
	}
	public function ShowMenu($authors, $genres)
	{
		$name = "name";
		$url = "autor";
		$class = "list-group";
		$author = $this -> htmlHelper -> getList($authors, $class, $name, $url);
		$name = "genre";
		$url = "genre";
		$genre = $this -> htmlHelper -> getList($genres, $class, $name, $url);
		$menu = $author."</br>".$genre;
		$view = FrontController::render('../resources/templates/menu.html', $menu);
		FrontController::setBody($view);
		return true;

	}
}

?>