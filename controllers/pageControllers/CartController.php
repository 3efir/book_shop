<?php
session_start();
/*
*@param view: store view object
*@param facade: store facade object
*/
class CartController
{
	protected $view;
    protected $facade;
// construct objects
	public function __construct()
	{
		$this -> view = new CartView();
		$this -> facade = new mainFacade();
		return true;
	}
// used facade for select cart items for logged user
// use view for show cart
	public function IndexAction()
	{
		$cart = $this -> facade -> cartItems($_SESSION['id']);
		$this -> view -> index($cart);
		return true;
	}
// if user logged add book to cart
// else show login form
	public function addAction()
	{
		if(!empty($_SESSION['id']))
		{
			$id = FrontController::getParams();
			$this -> facade -> addToCart($id);
			return true;
		}
		else
		{
			header("Location: /~user8/book_shop/login");
			return true;
		}
	}
// use facade for count books in cart
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
// call facade for remove book from cart
	public function removeAction()
	{
		$id = FrontController::getParams();
		$this -> facade -> removeFromCart($id);
		return true;
    }
// call facade for decreases count book in cart
    public function setCountAction()
    {
        $id = FrontController::getParams();
        $this -> facade -> setCount($id);
        header("Location: /~user8/book_shop/cart");
		return true;
    }
// facade: select payment types
// if not empty cart show send payment types else show empty cart
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
// call facade for transfers books from cart to orders
    public function sendOrderAction()
    {
		$cart = $this -> facade -> cartItems($_SESSION['id']);        
        $pay = $_POST['pay'];
        $user = $_SESSION['id'];
        $summ = $_COOKIE['total'];
        $this -> facade -> sendOrder($pay, $user, $summ, $cart);
        header("Location: /~user8/book_shop/cart", true, 301);
		return true;
    }
}
?>