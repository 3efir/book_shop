<?php
session_start();
class CartController
{
	protected $view;
	protected $facade;
	public function __construct()
	{
		$this -> view = new CartView();
		$this -> facade = new mainFacade();
	}
	public function IndexAction()
	{
		$cart = $this -> facade -> cartItems($_SESSION['id']);
		$this -> view -> index($cart);
	}
	public function addAction()
	{
		if(!empty($_SESSION['id']))
		{
			$id = FrontController::getParams();
			$this -> facade -> addToCart($id);
		}
		else
		{
			header("Location: /book_shop/login");
		}
	}
	public function countCart()
	{
		if(!empty($_SESSION['id']))
		{
			$result = $this -> facade -> cntCart($_SESSION['id']);
			$cnt = "( ".$result." )";
			return $cnt;
		}
		else
		{
			return $cnt = "( 0 )";
		}
	}
	public function removeAction()
	{
		$id = FrontController::getParams();
		$this -> facade -> removeFromCart($id);
	}
}


?>