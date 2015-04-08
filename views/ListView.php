<?php 
/*
*@htmlHelper storied htmlHelper obj
*function index render template for index body	
*function showHeader render template for header
*/
class ListView
{
	//htmlHelper obj
	protected $htmlHelper;
	//create htmlHelper obj
	public function __construct()
	{
		$this -> htmlHelper = new htmlHelper();
	}
	// rendering body
	// $arr - array with data from DB 
	public function IndexAction($data, $name, $url)
	{
		//class for div
		$class = "list-group";
		$ul = $this -> htmlHelper -> getList($data, $class, $name, $url);
		//second param - echo $test in template
		$view = FrontController::render('../resources/templates/index.html', $ul);
		FrontController::setBody($view);
		return true;
	}

}

?>