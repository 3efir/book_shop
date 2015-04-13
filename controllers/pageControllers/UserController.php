<?php
session_start();
/*
*@param facade: stores facade object
*@param view: stores view object
*/
class UserController
{
	protected $view;
	protected $facade;
	protected $OrdersModel;
// construct objects
	public function __construct()
	{
		$this -> view = new UserView();
		$this -> facade = new mainFacade();
		$this -> OrdersModel = new OrdersModel();
		return true;
	}
// used for show user profile
// if id from route !== id in session show 404 page
// if id == 7 redirect to admin
// if all good show order history
	public function profileAction()
	{
		$id = FrontController::getParams();
		if($id !== $_SESSION['id'])
		{
			header("Location: /~user8/book_shop/user/wtf");
			return true;
		}
		if(7 == $_SESSION['id'])
		{
			header("Location: /~user8/book_shop/admin");
			return true;
		}
		else
        {
            $user = $_SESSION['id'];  
            $result = $this -> OrdersModel -> test($user);
            $this -> view -> index($result);
			return true;
		}
	}
}
?>