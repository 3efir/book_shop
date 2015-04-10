<?php
session_start();
class AdminController
{
	protected $view;
    protected $facade;
    protected $ordersModel;
	public function __construct()
	{
		$this -> view = new AdminView();
        $this -> facade = new formFacade();
        $this -> ordersModel = new OrdersModel();
	}
	public function IndexAction()
	{
		if(7 == $_SESSION['id'])
		{
			$this -> view -> index();

		}
		else
		{
			header("Location: /~user8/book_shop/user/wtf");
		}
	}

	public function getUsersAction()
	{
		$result = $this -> facade -> getUsers();
		$this -> view -> showUsers($result);
	}

	public function addAuthorAction()
	{
		if($_POST['authorName'])
		{
			$result = $this -> facade -> addAuthor($_POST['authorName']);
			if($result === true)
			{
				$this -> view -> index('Author added');
			}
			else
			{
				$this -> view -> addAuthorForm($result);
			}
		}
		else
		{
			$this -> view -> addAuthorForm();
		}
	}

	public function addGenreAction()
	{
		if($_POST['genre'])
		{
			$result = $this -> facade -> addGenre($_POST['genre']);
			if($result === true)
			{
				$this -> view -> index('New genre added');
			}
			else
			{
				$this -> view -> addGenreForm($result);
			}
		}
		else
		{
			$this -> view -> addGenreForm();
		}
	}

	public function addBookAction()
    {
        $authors = $this -> mainFacade -> allAutors();
        $genres = $this -> mainFacade -> allGenres();
		if($_POST['title'])
		{
			$result = $this -> facade -> addGenre($_POST['genre']);
			if($result === true)
			{
				$this -> view -> index('New genre added');
			}
			else
			{
				$this -> view -> addBookForm($authors, $genres, $result);
			}
		}
		else
		{
			$this -> view -> addBookForm($authors, $genres);
		}
    }
    public function getOrdersAction()
    {
        $orders = $this -> ordersModel -> test();
        $this -> view -> showOrders($orders);  
    }
    public function setStatusAction()
    {
        $id = FrontController::getParams();
        if($_POST['status'])
        {
        
        }
        else
        {
            $stat = $this -> facade -> getStatus();
            $this -> view -> changeStatus($stat);
           return true; 
        }
    }
}



?>
