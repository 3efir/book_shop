<?php
session_start();
class LoginController
{
	protected $view;
	protected $facade;
	public function __construct()
	{
		$this -> view = new LoginView();
		$this -> facade = new formFacade();
	}
	public function IndexAction()
	{
		$this -> view -> showLoginForm();
		if(isset($_POST['submitLogin']))
		{
			$this -> checkLogin();
		}
	}
	public function checkLogin()
	{
		$email = trim($_POST['email']);
		$pass = strip_tags(trim($_POST['pass']));
		$result = $this -> facade -> checkLogin($email, $pass);
		if(is_array($result))
		{

				$_SESSION['user'] = $result[0]['name'];
				$_SESSION['id'] = $result[0]['id'];
				header("Location: /~user8/book_shop/user/profile/".$result[0]['id'], true, 301);
				exit();
		}
		else
		{
			$this -> view -> setError($result);
			$this -> view -> showLoginForm();
		}
	}
	public function closeSessionAction()
	{
		unset($_SESSION['id']);
		unset($_SESSION['user']);
		header("Location: /~user8/book_shop/", true, 301);
	}

}


?>
