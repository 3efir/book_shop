<?php 
class DescView
{
	protected $htmlHelper;
	
	public function __construct()
	{
		$this -> htmlHelper = new htmlHelper();
	}
	public function IndexAction($book)
	{
		$class = "desc";
		$div = $this -> htmlHelper -> book($book, $class);
		$view = FrontController::render('../resources/templates/index.html', 
		$div);
		FrontController::setBody($view);
		return true;
	}
}
?>