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
	public function addBookForm($err = '')
	{
		$form = FrontController::render('../resources/templates/adminBookForm.html', $err);
		$view = FrontController::render('../resources/templates/admin.html', $form);
		FrontController::setBody($view);
		return true;
	}
}



?>