<?php
session_start();
class UserController
{
	protected $view;
	protected $facade;
	public function __construct()
	{
		$this -> view = new UserView();
		$this -> facade = new mainFacade();
	}
	public function profileAction()
	{
		$id = FrontController::getParams();
		if($id !== $_SESSION['id'])
		{
			header("Location: /book_shop/user/wtf");
		}
		if(7 == $_SESSION['id'])
		{
			header("Location: /book_shop/admin");
		}
		else
		{
			$result = $this -> facade -> getOrders($id);
			$this -> view -> index($result);
		}
	}
	
	
}

?>