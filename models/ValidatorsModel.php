<?php
class ValidatorsModel
{
	protected $er = '';
	public function checkRegister($name, $email, $pass, $conf_pass)
	{
		$notNull = $this -> NotNull($name, $pass, $conf_pass);
		if ($notNull == '')
		{
			$checkPass = $this -> checkPass($pass, $conf_pass);
			if($checkPass == '')
			{
				$validEmail = $this -> validEmail($email);
				if($validEmail == '')
				{
					return true;
				}
				else
				{
					return $validEmail;
				}
			}
			else
			{
				return $checkPass;
			}
		}
		else
		{
			return $notNull;
		}
	}

	public function NotNull($name, $pass, $conf_pass)
	{
		$this -> er = '';
		if ('' == $name)
		{
			$this -> er .= 'Enter name</br>';
		}
		if ('' == $pass)
		{
			$this -> er .= 'Enter password</br>';
		}
		if ('' == $conf_pass)
		{
			$this -> er .= 'Enter confirm password</br>';
		}
		return $this -> er;
	}

	public function checkPass($pass, $conf_pass)
	{
		if($pass !== $conf_pass)
		{
			$this -> er .= 'passwords must match</br>';
		}
		return $this -> er;
	}

	public function validEmail($email)
	{
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$this -> er .= 'email not valid</br>';
		}
		return $this -> er;
	}
}

?>