<?php
/*
*@param DBmodel: store object Data Base class
*@param ValidModel: store object Validator class 
*@param encoder: store object ecnoder/decoder class
*
*/
class formFacade
{
	private $DBmodel;
	private $ValidModel;
	private $encoder;
// create objects DB, Validator and Encoder classes
	public function __construct()
	{
		$this -> DBmodel = DataBase::getInstance();
		$this -> ValidModel = new ValidatorsModel();
		$this -> encoder = new EncoderDecoder();
		return true;
	}
// check incoming values from registration form
// return true or errors if fields empty or not correct
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
// try hash password and then insert new user to 'users' table
// return true or errors
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
// check login form for correct
// return errors or id and name of logged user
	public function checkLogin($email, $pass)
	{
		if($email !== '' && $pass !== '')
		{
			try{
				$result = $this -> DBmodel -> SELECT(" id, name, pass ") ->
				from(" users ") -> where(" email = '".$email."'") -> selected();
			}
			catch (Exception $e)
			{
				return $e -> getMessage().". Email or password not correct.";
			}
			if($this -> encoder -> validPass($result[0]['pass'], $pass) === true)
			{
				$result = $this -> DBmodel -> SELECT(" id, name ") ->
				from(" users ") -> where(" email = '".$email."'") -> selected();
				return $result;
			}
		}
		else
		{
			return "fields email and password cant be empty";
		}
	}
// select and return all users
	public function getUsers()
	{
		$result = $this -> DBmodel -> SELECT(" id, name, email ") -> from("
		users ") -> selected();
		return $result;
	}
// try add new author
// return true or errors
	public function addAuthor($name)
	{
		$author = strip_tags(trim($name));
		if($author !== '')
		{
			try{
				$arr = array($author);
				$this -> DBmodel -> INSERT(" autor ") -> keys(" name ") ->
					values(" ? ") -> insertUpdate($arr);
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
// try add new genre
// return true or errors
	public function addGenre($name)
	{
		$genre = strip_tags(trim($name));
		if($genre !== '')
		{
			try{
				$arr = array($genre);
				$this -> DBmodel -> INSERT(" genre ") -> keys(" genre ") ->
					values(" ? ") -> insertUpdate($arr);
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
// select and return all order status
    public function getStatus()
    {
        $status = $this -> DBmodel -> SELECT(" id, name ") -> from(" status ")
			-> selected();
        return $status;
    }
// set new status for order 
// return true or errors
	public function setStatus($status)
	{
		try
		{
			$arr = array($status);
			$this -> DBmodel -> UPDATE(" orders ") -> set(" status ") ->
				where(" id = ".$_COOKIE['status']) -> insertUpdate($arr);
			setCookie("status", "");
			return true;
		}
		catch(Exception $e)
		{
			return $e -> getMessage();
		}
	}
// check add new book form, and then add insert to new values to tables(books,
// author_book, book_genre). Return true or errors. 
	public function addBook($title, $desc, $autors, $genres, $price)
	{
		$notNull = $this -> ValidModel -> notNullBook($title, $desc, $autors,
		$genres, $price);
		if('' == $notNull)
		{
			if(is_uploaded_file($_FILES['file']['tmp_name']))
			{
				try
				{
					if($this -> uploadFile())
					{
						$file = "/~user8/book_shop/resources/images/books/
						".basename($_FILES['file']['name']);
						$arr = array($title, $desc, $file, $price);
						$this -> DBmodel -> INSERT(" books ") -> keys(" title,
						description, img, price ") -> values(" ?, ?, ?, ? ")
							-> insertUpdate($arr);
						$id = $this -> DBmodel -> getLastInsertId();
						$i = 0;
						foreach($autors as $v)
						{
							$arr = array($v[$i], $id);
							$this -> DBmodel -> INSERT(" autor_book ") -> keys("
							id_autor, id_book ") -> values(" ?, ? ")
								-> insertUpdate($arr);
							$i++;
						}
						$i = 0;
						foreach($genres as $v)
						{
							$arr = array($v[$i], $id);
							$this -> DBmodel -> INSERT(" book_genre ") -> keys("
							id_genre, id_book ") -> values(" ?, ? ")
								-> insertUpdate($arr);
							$i++;
						}
						return true;
					}
				}
				catch(Exception $e)
				{
					return $e -> getMessage();
				}
			}
		}
		else
		{
			return $notNull;
		}
	}
// upload files to directory 'images'
// return true or false
	public function uploadFile()
	{
		$uploaddir = 'C:\xampp\htdocs\~user8\book_shop\resources\images\books\\';
		if(is_writable($uploaddir))
		{
			$uploadfile = $uploaddir.basename($_FILES['file']['name']);
			if(!file_exists($uploadfile))
			{
				if(move_uploaded_file($_FILES["file"]["tmp_name"], $uploadfile))
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		else
		{
			return false;
		}
	}
//select and return all discounts
	public function getDiscounts()
	{
		$result = $this -> DBmodel -> SELECT(" id, discount ") -> from("
		discount ") -> selected();
		return $result;
	}
// set value for discount
// return true or errors
	public function updateDisc($id, $disc)
	{
		if($disc !== '')
		{
			try
			{
				$arr = array($disc);
				$this -> DBmodel -> UPDATE(" discount ") -> set(" discount ")
					-> where(" id = $id ") -> insertUpdate($arr);
				return true;
			}
			catch(Exception $e)
			{
				return $e -> getMessage();
			}
		}
	}
// add new discount
// return true or errors
	public function addDisc($disc)
	{
		if($disc !== '')
		{
			try
			{
				$arr = array($disc);
				$this -> DBmodel -> INSERT(" discount ") -> keys(" discount ")
					-> values(" ? ") -> insertUpdate($arr);
				return true;
			}
			catch(Exception $e)
			{
				return $e -> getMessage();
			}
		}
	}
// add discount to user
// return true or error
	public function addUserDiscount($id, $disc)
	{
		if($disc !== '')
		{
			try
			{
				$arr = array($id, $disc);
				$this -> DBmodel -> INSERT(" disc_user ") -> keys(" id_user,
				id_disc ") -> values(" ?, ? ") -> insertUpdate($arr);
				return true;
			}
			catch(Exception $e)
			{
				return $e -> getMessage();
			}
		}
	}
}
?>
