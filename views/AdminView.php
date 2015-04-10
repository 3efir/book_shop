<?php
class AdminView
{
	protected $htmlHelper;

	public function __construct()
	{
		$this -> htmlHelper = new htmlHelper();
	}
	public function index($err = '')
	{
		$view = FrontController::render('../resources/templates/admin.html', $err);
		FrontController::setBody($view);
		return true;
	}
	public function showUsers($data)
	{
		$print = $this -> htmlHelper -> UsersList($data);
		$view = FrontController::render('../resources/templates/admin.html', $print);
		FrontController::setBody($view);
		return true;
	}
	public function addAuthorForm($err = '')
	{
		$form = FrontController::render('../resources/templates/adminAuthorForm.html', $err);
		$view = FrontController::render('../resources/templates/admin.html', $form);
		FrontController::setBody($view);
		return true;
	}
	public function addGenreForm($err = '')
	{
		$form = FrontController::render('../resources/templates/adminGenreForm.html', $err);
		$view = FrontController::render('../resources/templates/admin.html', $form);
		FrontController::setBody($view);
		return true;
	}
	public function addBookForm($authors, $genres, $err = '')
    {
        $mAuthors = $this -> htmlHelper -> getMultiAuthors($authors);
		$form = FrontController::render('../resources/templates/adminBookForm.html', $err);
		$view = FrontController::render('../resources/templates/admin.html', $form);
		FrontController::setBody($view);
		return true;
    }
	public function showOrders($data)
	{
		$view = FrontController::render('../resources/templates/admin.html', $data);
		FrontController::setBody($view);
		return true;
    }
	public function changeStatus($data)
    {
        $radio = $this -> htmlHelper -> radioStatus($data);
        $status = FrontController::render('../resources/templates/status.html', $radio);
		$view = FrontController::render('../resources/templates/admin.html', $status);
		FrontController::setBody($view);
		return true;
	}


}



?>
