<?php
session_start();
/*
*@param view: store view obj
*@param facade: store facade obj
*/
class LoginController
{
	protected $view;
	protected $facade;
// construct objects
	public function __construct()
	{
		$this -> view = new LoginView();
		$this -> facade = new formFacade();
		return true;
	}
// call view for show login form
// if form submit call check login
	public function IndexAction()
	{
		$this -> view -> showLoginForm();
		if(isset($_POST['submitLogin']))
		{
			$this -> checkLogin();
			return true;
		}
	}
// check login form if correct start session
	public function checkLogin()
	{
		$email = trim($_POST['email']);
		$pass = strip_tags(trim($_POST['pass']));
		$result = $this -> facade -> checkLogin($email, $pass);
		if(is_array($result))
		{

				$_SESSION['user'] = $result[0]['name'];
				$_SESSION['id'] = $result[0]['id'];
				header("Location: /~user8/book_shop/user/profile/"
				.$result[0]['id'], true, 301);
				exit();
		}
		else
		{
			$this -> view -> setError($result);
			$this -> view -> showLoginForm();
			return true;
		}
	}
// logout, close session
	public function closeSessionAction()
	{
		unset($_SESSION['id']);
		unset($_SESSION['user']);
		header("Location: /~user8/book_shop/", true, 301);
		exit();
	}
}
?>