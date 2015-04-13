<?php
/*
* class work with admin controller
* used for prepare templates
*/
class AdminView
{
	protected $htmlHelper;
	public function __construct()
	{
		$this -> htmlHelper = new htmlHelper();
	}
	public function index($err = '')
	{
		$view = FrontController::render('../resources/templates/admin.html',
		$err);
		FrontController::setBody($view);
		return true;
	}
	public function showUsers($data)
	{
		$print = $this -> htmlHelper -> UsersList($data);
		$view = FrontController::render('../resources/templates/admin.html',
		$print);
		FrontController::setBody($view);
		return true;
	}
	public function addAuthorForm($err = '')
	{
		$form = FrontController::render(
		'../resources/templates/adminAuthorForm.html', $err);
		$view = FrontController::render(
		'../resources/templates/admin.html', $form);
		FrontController::setBody($view);
		return true;
	}
	public function addGenreForm($err = '')
	{
		$form = FrontController::render(
		'../resources/templates/adminGenreForm.html', $err);
		$view = FrontController::render(
		'../resources/templates/admin.html', $form);
		FrontController::setBody($view);
		return true;
	}
	public function addBookForm($authors, $genres, $err = '')
    {
        $mAuthors = $this -> htmlHelper -> getMultiAuthors($authors);
		$mGenres = $this -> htmlHelper -> getMultiGenres($genres);
		$file = file_get_contents(
	'C:\xampp\htdocs\~user8\book_shop\resources\templates\adminBookForm.html');
		$arr = array("%AUTORS%" => $mAuthors, "%GENRES%" => $mGenres,
					"%ERRORS%" => $err);
		$form = FrontController::templateRender($file, $arr);
		$view = FrontController::render('../resources/templates/admin.html',
		$form);
		FrontController::setBody($view);
		return true;
    }
	public function showOrders($data, $id = '')
	{
		if('' !== $id)
		{
			$link = "<a href='/~user8/book_shop/admin/userDiscount/".$id.
			"'>Add discount</a>";
		}
		else 
		{
			$link = '';
		}
		$view = FrontController::render('../resources/templates/admin.html',
		$data.$link);
		FrontController::setBody($view);
		return true;
    }
	public function changeStatus($data)
    {
        $radio = $this -> htmlHelper -> radioStatus($data);
        $status = FrontController::render('../resources/templates/status.html',
		$radio);
		$view = FrontController::render('../resources/templates/admin.html',
		$status);
		FrontController::setBody($view);
		return true;
	}
	public function showDiscounts($disc)
	{
		$discList = $this -> htmlHelper -> discounts($disc);
		$view = FrontController::render('../resources/templates/admin.html',
		$discList);
		FrontController::setBody($view);
		return true;
	}
	public function discountForm($id)
	{
		$href = "setDiscount/$id";
		$arr = array('%HREF%' => $href);
		$file = file_get_contents(
	'C:\xampp\htdocs\~user8\book_shop\resources\templates\discountForm.html');
		$form = FrontController::templateRender($file, $arr);
		$view = FrontController::render('../resources/templates/admin.html', 
		$form);
		FrontController::setBody($view);
		return true;
	}
	public function newDiscountForm()
	{
		$href = "newDiscount";
		$arr = array('%HREF%' => $href);
		$file = file_get_contents(
	'C:\xampp\htdocs\~user8\book_shop\resources\templates\discountForm.html');
		$form = FrontController::templateRender($file, $arr);
		$view = FrontController::render('../resources/templates/admin.html', 
		$form);
		FrontController::setBody($view);
		return true;
	}
	public function userDiscounts($disc, $id)
	{
		$d = $this -> htmlHelper -> getRadioDisc($disc, $id);
		$view = FrontController::render('../resources/templates/admin.html', 
		$d);
		FrontController::setBody($view);
		return true;
	}
}
?>