<?php
error_reporting( E_ALL );
ini_set("display_errors", 1);
class FrontController
{
	protected $_controller, $_action;
	static $_instance, $_body, $_params, $lang;

	public static function getInstance()
	{
		if(!(self::$_instance instanceOf self))
			self::$_instance = new self();
		return self::$_instance;
	}

	private function __construct()
	{
		$request = $_SERVER['REQUEST_URI'];
		//user/get/id/1
		$splits = explode('/',trim($request,'/'));
		//Выбор контроллера
		$this->_controller = !empty($splits[2])?ucfirst($splits[2]).'Controller':'IndexController';
		//Выбор экшена
		$this->_action = !empty($splits[3])?$splits[3].'Action':'indexAction';
		if(!empty($splits[4]))
		{
			self::$_params = $splits[4];
		}
	}

	public function route()
	{
		if(class_exists($this->getController()))
		{
			$rc = new ReflectionClass($this->getController());
			if($rc->hasMethod($this->getAction()))
			{
				$controller = $rc->newInstance();
				$method = $rc->getMethod($this->getAction());
				$method->invoke($controller);
			}
			else
			{
				echo "<img src='http://hq-wallpapers.ru/wallpapers/4/hq-wallpapers_ru_computer_17752_1920x1200.jpg'/>";
			}
		}
		else
		{
			echo "<img src='http://hq-wallpapers.ru/wallpapers/4/hq-wallpapers_ru_computer_17752_1920x1200.jpg'/>";
		}
	}
	public static function render($file,$replace='')
	{
		ob_start();
		$test = $replace;
		$cart = new CartController();
		$cnt = $cart -> countCart();
		include(__DIR__.'/'.$file);
		return ob_get_clean();
    }
    public static function templateRender($file, $arr)
    {
        foreach($arr as $key=>$val)
        {
            $file = str_replace($key, $val, $file);
        }
        return $file;
    }
	public static function getParams()
	{
		return self::$_params;
	}
	function getController()
	{
		return $this->_controller;
	}
	function getAction()
	{
		return $this->_action;
	}
	function getBody()
	{
		return self::$_body;
	}
	public static function setBody($body)
	{
		self::$_body = $body;
		return self::$_body;
	}
	public static function setLang($data)
	{
		self::$lang = $data;
		return self::$lang;
	}
	public static function getLang()
	{
		return self::$lang;
	}
}
?>
