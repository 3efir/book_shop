<?php
session_start();
/*
*@param view: store object of view
*@param facade: store object of
*@param ordersModel: store object orders model
*@param mailFacade: store facade object
*/
class AdminController
{
	protected $view;
    protected $facade;
    protected $ordersModel;
	protected $mainFacade;
// construct objects
	public function __construct()
	{
		$this -> view = new AdminView();
        $this -> facade = new formFacade();
        $this -> ordersModel = new OrdersModel();
		$this -> mainFacade = new mainFacade();
	}
// check session, number 7 is id register admin in db
	public function IndexAction()
	{
		if(7 == $_SESSION['id'])
		{
			$this -> view -> index();
			return true;
		}
		else
		{
			header("Location: /~user8/book_shop/user/wtf");
			return false;
		}
	}
// use facade for select all users
	public function getUsersAction()
	{
		$result = $this -> facade -> getUsers();
		$this -> view -> showUsers($result);
		return true;
	}
// if form submit use facade for try add author
// else call view for show add author form
	public function addAuthorAction()
	{
		if($_POST['authorName'])
		{
			$result = $this -> facade -> addAuthor($_POST['authorName']);
			if($result === true)
			{
				$this -> view -> index('Author added');
				return true;
			}
			else
			{
				$this -> view -> addAuthorForm($result);
				return false;
			}
		}
		else
		{
			$this -> view -> addAuthorForm();
			return true;
		}
	}
// if form submit use facade for try add genre
// else call view for show add genre form
	public function addGenreAction()
	{
		if($_POST['genre'])
		{
			$result = $this -> facade -> addGenre($_POST['genre']);
			if($result === true)
			{
				$this -> view -> index('New genre added');
				return true;
			}
			else
			{
				$this -> view -> addGenreForm($result);
				return false;
			}
		}
		else
		{
			$this -> view -> addGenreForm();
			return true;
		}
	}
/*
* use facade for select all authors and genres
* if form submit use facade for try add new book
* else call view for show add book form
*/
	public function addBookAction()
    {
        $authors = $this -> mainFacade -> allAutors();
        $genres = $this -> mainFacade -> allGenres();
		if($_POST['title'])
		{
			$title = strip_tags(trim($_POST['title']));
			$desc = strip_tags(trim($_POST['description']));
			$autors = $_POST['autors'];
			$genre = $_POST['genres'];
			$price = strip_tags(trim($_POST['price']));
			$addBook = $this -> facade -> addBook($title, $desc, $autors, 
			$genre, $price);
			if($addBook === true)
			{
				$this -> view -> index('New book added');
				return true;
			}
			else
			{
				$this -> view -> addBookForm($authors, $genres, $addBook);
				return false;
			}
		}
		else
		{
			$this -> view -> addBookForm($authors, $genres);
			return true;
		}
    }
// select all orders and use view for show it
    public function getOrdersAction()
    {
        $orders = $this -> ordersModel -> test();
        $this -> view -> showOrders($orders);
		return true;
    }
// change status for selected order
    public function setStatusAction()
    {
        $id = FrontController::getParams();
		setCookie("status", $id);
        if($_POST['status'])
        {
        	$try = $this -> facade -> setStatus($_POST['status']);
			if($try === true)
			{
				header("Location: /~user8/book_shop/admin/getOrders");
				return true;
			}
        }
        else
        {
            $stat = $this -> facade -> getStatus();
            $this -> view -> changeStatus($stat);
           return true;
        }
    }
// use order model for select orders for selected user
// and then use view for display it
	public function showUserAction()
	{
		$id = FrontController::getParams();
		$orders = $this -> ordersModel -> test($id);
		$this -> view -> showOrders($orders, $id);
		return true;
	}
// use facade for select discounts
// use view for show discounts
	public function discountsAction()
	{
		$disc = $this -> facade -> getDiscounts();
		$this -> view -> showDiscounts($disc);
		return true;
	}
// if form submit try update discount value
// else show form for update discount
	public function setDiscountAction()
	{
		$id = FrontController::getParams();
		if(!$_POST['update'])
		{
			$this -> view -> discountForm($id);
			return true;
		}
		else
		{
			$result = $this -> facade -> updateDisc($id, $_POST['disc']);
			if($result === true)
			{
				header("Location: /~user8/book_shop/admin/discounts");
				return true;
			}
		}
		return true;
	}
// if form submit try add new discount
// else show add new discount form
	public function newDiscountAction()
	{
		if(!$_POST['add'])
		{
			$this -> view -> newDiscountForm();
			return true;
		}
		else
		{
			$result = $this -> facade -> addDisc($_POST['disc']);
			if($result === true)
			{
				header("Location: /~user8/book_shop/admin/discounts");
				return true;
			}
		}
	}
// if form submit try add selected discount to user
// else show discount for selected user
	public function userDiscountAction()
	{
		$id = FrontController::getParams();
		if($_POST['discount'])
		{
			$this -> facade -> addUserDiscount($id, $_POST['discount']);
			header("Location: /~user8/book_shop/admin");
			return true;
		}
		else
		{
			$disc = $this -> facade -> getDiscounts();
			$this -> view -> userDiscounts($disc, $id);
			return true;
		}
	}
}
?>