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
			header("Location: /~user8/book_shop/user/wtf");
		}
		if(7 == $_SESSION['id'])
		{
			header("Location: /~user8/book_shop/admin");
		}
		else
        {
            $user = $_SESSION['id'];
			$result = $this -> facade -> getOrders($id);
            $this -> view -> index($result);
            $t = new OrdersModel();
            $result = $t -> test($user);
            $this -> view -> index($result);
		}
	}
	
	
}

?>
