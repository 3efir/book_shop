<?php
session_start();
class CartController
{
	protected $view;
    protected $facade;
    protected static $total;
	public function __construct()
	{
		$this -> view = new CartView();
		$this -> facade = new mainFacade();
	}
	public function IndexAction()
	{
		$cart = $this -> facade -> cartItems($_SESSION['id']);
		$this -> view -> index($cart);
	}
	public function addAction()
	{
		if(!empty($_SESSION['id']))
		{
			$id = FrontController::getParams();
			$this -> facade -> addToCart($id);
		}
		else
		{
			header("Location: /~user8/book_shop/login");
		}
	}
	public function countCart()
	{
		if(!empty($_SESSION['id']))
		{
			$result = $this -> facade -> cntCart($_SESSION['id']);
			$cnt = "( ".$result." )";
			return $cnt;
		}
		else
		{
			return $cnt = "( 0 )";
		}
	}
	public function removeAction()
	{
		$id = FrontController::getParams();
		$this -> facade -> removeFromCart($id);
    }
    public function setCountAction()
    {
        $id = FrontController::getParams();
        $this -> facade -> setCount($id);
        header("Location: /~user8/book_shop/cart");
    }
    public function orderAction()
    {
        $payment = $this -> facade -> getPayment();
        $cart = $this -> facade -> cartItems($_SESSION['id']);
        if(!empty($cart))
        {
            $this -> view -> showOrder($cart, $payment);
        }
        else
        {
            $this -> view -> showOrder($cart);
        }
        return true;
    }

    public function sendOrderAction()
    {
		$cart = $this -> facade -> cartItems($_SESSION['id']);        
        $pay = $_POST['pay'];
        $user = $_SESSION['id'];
        $summ = $_COOKIE['total'];
        $this -> facade -> sendOrder($pay, $user, $summ, $cart);
        header("Location: /~user8/book_shop/cart", true, 301);
    }
    
}


?>
