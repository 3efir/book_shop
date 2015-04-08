<?php
class formFacade
{
	private $DBmodel;
	private $ValidModel;
	private $encoder;

	public function __construct()
	{
		$this -> DBmodel = DataBase::getInstance();
		$this -> ValidModel = new ValidatorsModel();
		$this -> encoder = new EncoderDecoder();
	}
	public function checkRegister($name, $email, $pass, $conf_pass)
	{
		try {
			$result = $this -> ValidModel -> checkRegister($name, $email,
			$pass, $conf_pass);
			return $result;
		}
		catch (Exception $e)
        {
            return $e -> getMessage();
        }
	}
	public function addUser($name, $email, $pass)
	{
		try {
			$pwd = $this -> encoder -> getHashPass($pass);
			$arr = array($name, $pwd, $email);
			$result = $this -> DBmodel -> INSERT(" users ") -> keys(" name,
			pass, email ") -> values( " ?, ?, ? " ) -> insertUpdate($arr) ;
			return $result;
		}
        catch (Exception $e)
        {
            return $e -> getMessage();
        }

	}
	public function checkLogin($email, $pass)
	{
		if($email !== '' && $pass !== '')
		{
			try{
				$result = $this -> DBmodel -> SELECT(" id, name, pass ") ->
				from(" users ") -> where(" email = '".$email."'") -> selected();
				//print_r($result);
			}
			catch (Exception $e)
			{
				return $e -> getMessage().". Email or password not correct.";
			}
			if($this -> encoder -> validPass($result[0]['pass'], $pass) === true)
			{
				return $result;
			}
		}
		else
		{
			return "fields email and password cant be empty";
		}
	}
	public function getUsers()
	{
		$result = $this -> DBmodel -> SELECT(" id, name, email ") -> from(" users ")
		-> selected();
		return $result;
	}
	public function addAuthor($name)
	{
		$author = strip_tags(trim($name));
		if($author !== '')
		{
			try{
				$arr = array($author);
				$this -> DBmodel -> INSERT(" autor ") -> keys(" name ") -> values(" ? ") -> insertUpdate($arr);
				return true;
			}
			catch(Exception $e)
			{
				return $e -> getMessage();
			}
		}
		else
		{
			return "Enter author name";
		}
	}
	public function addGenre($name)
	{
		$genre = strip_tags(trim($name));
		if($genre !== '')
		{
			try{
				$arr = array($genre);
				$this -> DBmodel -> INSERT(" genre ") -> keys(" genre ") -> values(" ? ") -> insertUpdate($arr);
				return true;
			}
			catch(Exception $e)
			{
				return $e -> getMessage();
			}
		}
		else
		{
			return "Enter genre";
		}
	}
}
?>