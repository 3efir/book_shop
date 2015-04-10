<?php
class RegisterController
{
	private $facade;
	private $view;
	public function __construct()
	{
		$this -> facade = new formFacade();
		$this -> view = new RegisterView();
	}
	public function IndexAction()
	{
		$this -> view -> showForm();
		if(isset($_POST['submit']))
		{
			$this -> checkForm();
		}
	}
	public function checkForm()
	{
		$name = strip_tags(trim($_POST['name']));
		$email = strip_tags(trim($_POST['email']));
		$pass = strip_tags(trim($_POST['pass']));
		$conf_pass = strip_tags(trim($_POST['conf_pass']));
		$result = $this -> facade -> checkRegister($name, $email, $pass, $conf_pass);
		if($result === true)
		{
			$add = $this -> facade -> addUser($name, $email, $pass, $conf_pass);
			if($add === true)
			{
				$this -> view -> setError("Thanks for registration. Now u can login");
				$this -> view -> showForm();
			}
			else
			{
				$this -> view -> setError("this email already exists");
				$this -> view -> showForm();
			}
		}
		else
		{
			$this -> view -> setError($result);
			$this -> view -> showForm();
		}
	}
}

?>
