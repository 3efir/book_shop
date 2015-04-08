<?php
class CartView
{
	protected $htmlHelper;
	public function __construct()
	{
		$this -> htmlHelper = new htmlHelper();
	}
	public function index($cart)
	{
		$table = $this -> htmlHelper -> getCartTable($cart);
		$view = FrontController::render('../resources/templates/cart.html',$table);
		FrontController::setBody($view);
		return true;
	}
}



?>