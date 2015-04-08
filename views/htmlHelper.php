<?php
class htmlHelper
{
	public function allBooks($arr, $class)
	{
		$result = '';
			foreach ($arr as $key => $value)
			{
				$tmp = "<div class=$class>";
				$tmp .= "<img src='".$value['img']."' /><br/>";
				$tmp .= $value['title']."</br>";
				$tmp .= $value['name']."</br>";
				$tmp .= $value['genre']."</br>";
				$tmp .= $value['price']."грн </br>";
				$tmp .= "<ul class='nav nav-pills nav-justified'>
					<li role='presentation'><a href='
					/book_shop/description/index/".$value['id']."'>Description
			</a></li><li role='presentation'><a href='/book_shop/cart/add/".$value['id']."' class='test'>Buy</a></li>
					</ul></div>";
				$result .= $tmp;
			}
		return $result;
	}
	public function book($book, $class)
	{
		$result = "<p class=$class>";
		//echo $result;
		//print_r($book);
		foreach ($book as $value)
		{
			//print_r($value);
			$result .= "<img src='".$value['img']."' /></br>";
			$result .= $value['title']."</br>";
			$result .= $value['name']."</br>";
			$result .= $value['genre']."</br>";
			$result .= $value['price']."грн </br>";
			$result .= "<ul class='nav nav-pills nav-justified'>
				<li role='presentation'><a href='/book_shop/cart/add/".$value['id']."'>Buy</a></li>
				</ul></p>";
		}
		return $result;
	}
	public function getList($genres, $class, $name, $url)
	{
		$result = "<ul class=$class><h2>$url</h2>";
		foreach ($genres as $value)
		{
			$tmp = "<a href='/book_shop/".$url."/show/".$value['id']."'
			class='list-group-item list-group-item-info'>".$value[$name] ."</a>";
			$result .= $tmp;
		}
		$result .= "</ul>";
		return $result;
	}
	public function UsersList($data)
	{
		$result = "<ul class=list-group>";
		foreach ($data as $value)
		{
			$tmp = "<a href='/book_shop/admin/showUser/".$value['id']."'
			class='list-group-item list-group-item-info'>".$value['name'].
			"(".$value['email'].")</a>";
			$result .= $tmp;
		}
		$result .= "</ul>";
		return $result;
	}
	public function getLogin()
	{
		$result = "<li role='presentation' id='enter'><a href='/book_shop/login'>Вход</a></li>";
		$result .= "<li role='presentation'><a href='/book_shop/register'>Регистрация</a></li>";
		return $result;
	}
	public function getProfileLinks($id, $name)
	{
		$result = "<li role='presentation' id='enter'><a href='/book_shop/user/profile/".$id."'>".$name."</a></li>";
		$result .= "<li role='presentation'><a href='/book_shop/login/closeSession'>Выход</a></li>";
		return $result;
	}
	public function getCartTable($cart)
	{
		if(empty($cart))
		{
			$result .= "<tr><td></td><td></td><td>Your cart is empty</td><td></td><td></td><td></td></tr>";
			return $result;
		}
		else
		{
			$i = 0;
			$result = '';
			$summ = 0;
			foreach($cart as $value)
			{
				$result .= "<tr><td>".$i++."</td>";
				$result .= "<td>".$value['title']."</td>";
				$result .= "<td>".$value['cnt']."</td>";
				$result .= "<td>".$value['price']."</td>";
				$result .= "<td>".$value['cnt']*$value['price']."</td>";
				$result .= "<td><a href='/book_shop/cart/remove/".$value['Book_id']."'> X </a></td></tr>";
				$summ = $summ + ($value['cnt']*$value['price']);
			}
			$result .= "<tr><td></td><td></td><td></td><td>ТОТАЛ</td><td>".$summ*(100 - $cart[0]['discount'])."</td><td></td></tr>";
			return $result;
		}
	}
}

?>