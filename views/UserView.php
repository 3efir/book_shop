<?php
class UserView
{
	protected $htmlHelper;
	public function __construct()
	{
		$this -> htmlHelper = new htmlHelper();
	}
	public function index($data)
	{
		$view = FrontController::render('../resources/templates/UserProfile.html');
		FrontController::setBody($view);
		return true;
	}
	
}

?>