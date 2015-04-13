<?php
class CartView
{
	protected $htmlHelper;
	public function __construct()
	{
		$this -> htmlHelper = new htmlHelper();
	}
	public function index($cart)
	{
		$table = $this -> htmlHelper -> getCartTable($cart);
		$view = FrontController::render('../resources/templates/cart.html',
		$table);
		FrontController::setBody($view);
		return true;
    }
    public function showOrder($cart, $payment = '')
    {
        $table = $this -> htmlHelper -> getCartTable($cart);
        if('' !== $payment)
        {
            $pay = $this -> htmlHelper -> getPayment($payment);
            $order = FrontController::render(
			'../resources/templates/order.html', $pay);
            $table = $table.$order;
        }
        $view = FrontController::render('../resources/templates/cart.html',
		$table);
        FrontController::setBody($view);
        return true;
    }
}
?>