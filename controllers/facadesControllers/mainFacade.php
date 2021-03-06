<?php
/*
*@param DBmodel: store object Data Base class
*/
class mainFacade
{
    private $DBmodel;
// create Data Base object
    public function __construct()
    {
        $this -> DBmodel = DataBase::getInstance();
    }
// select and return all books, group concat autors and genres
    public function allBooks()
    {
        $result = $this -> DBmodel -> SELECT(" b.id, b.title, b.img, b.price,
            GROUP_CONCAT(distinct a.name SEPARATOR ', ') as name, GROUP_CONCAT(
			distinct g.genre SEPARATOR ', ') as genre ") -> from(' books b ')
			-> left(' autor_book ab ') -> on(' ab.id_book = b.id ') -> left(' 
			book_genre bg ') -> on(' bg.id_book = b.id ') -> left(' autor a ')
			-> on(' a.id = ab.id_autor ') -> left(' genre g ') -> on('
			g.id = bg.id_genre ') -> GROUP(' b.id ') -> selected();
        return $result;
    }
// select and return all authors
    public function allAutors()
    {
        $result = $this -> DBmodel -> SELECT(" id, name ") -> from(" autor ")
            -> selected();
        return $result;
    }
// select and return all genres
    public function allGenres()
    {
        $result = $this -> DBmodel -> SELECT(" id, genre ") -> from(" genre ")
            -> selected();
        return $result;
    }
// select and return books by author id
    public function getBooksByAutor($id)
    {
        $result = $this -> DBmodel -> SELECT(" b.id, b.title, b.img, b.price,
            GROUP_CONCAT(distinct a.name SEPARATOR ', ') as name, GROUP_CONCAT(
			distinct g.genre SEPARATOR ', ') as genre ") -> from(' books b ') 
			-> left(' autor_book ab ') -> on(' ab.id_book = b.id ') -> left(' 
			book_genre bg ') -> on(' bg.id_book = b.id ') -> left(' autor a ') 
			-> on(' a.id = ab.id_autor ') -> left(' genre g ') -> on(' 
			g.id = bg.id_genre ') -> where(" a.id = ".$id) -> GROUP(' b.id ') 
			-> selected();
        return $result;
    }
// select and return books by id genre	
    public function getBooksByGenre($id)
    {
        $result = $this -> DBmodel -> SELECT(" b.id, b.title, b.img, b.price,
            GROUP_CONCAT(distinct a.name SEPARATOR ', ') as name, GROUP_CONCAT(
			distinct g.genre SEPARATOR ', ') as genre ") -> from(' books b ') 
			-> left(' autor_book ab ') -> on(' ab.id_book = b.id ') -> left(' 
			book_genre bg ') -> on(' bg.id_book = b.id ') -> left(' autor a ') 
			-> on(' a.id = ab.id_autor ') -> left(' genre g ') -> on(' 
			g.id = bg.id_genre ') -> where(" g.id = ".$id) -> GROUP(' b.id ') 
			-> selected();
        return $result;
    }
// select and return book by id
    public function getBook($id)
    {
        $result = $this -> DBmodel -> SELECT(" b.id, b.title, b.img, b.price,
            GROUP_CONCAT(distinct a.name SEPARATOR ', ') as name, GROUP_CONCAT(
			distinct g.genre SEPARATOR ', ') as genre ") -> from(' books b ') 
			-> left(' autor_book ab ') -> on(' ab.id_book = b.id ') -> left(' 
			book_genre bg ') -> on(' bg.id_book = b.id ') -> left(' autor a ') 
			-> on(' a.id = ab.id_autor ') -> left(' genre g ') -> on(' g.id = 
			bg.id_genre ') -> where(" b.id = ".$id) -> GROUP(' b.id ') 
			-> selected();
        return $result;
    }
// count and return books in cart
    public function cntCart($id)
    {
        $result = $this -> DBmodel -> SELECT(" cnt ") -> from(" shopping_cart
            ") -> where(" User_id = $id ") -> selected();
        if(!empty($result))
        {
            $cnt = 0;
            foreach($result as $value)
            {
                $cnt = $cnt + $value['cnt'];
            }
            return $cnt;
        }
        else
        {
            return 0;
        }
    }
// add book to cart
    public function addToCart($id)
    {
        $result = $this -> DBmodel -> SELECT(" Book_id, cnt ") -> from("
            shopping_cart ") -> where(" User_id = ".$_SESSION['id']) 
			-> selected();
        if(empty($result))
        {
            $arr = array($_SESSION['id'], $id, 1);
            $this -> DBmodel -> INSERT(" shopping_cart ") -> keys(" User_id,
                Book_id, cnt ") -> values(" ?, ?, ? ") -> insertUpdate($arr);
            header("Location: /~user8/book_shop/");
            return true;
        }
        else
        {
            foreach($result as $value)
            {
                if($value['Book_id'] == $id)
                {
                    $cnt = array($value['cnt']+1);
                    $this -> DBmodel -> UPDATE(" shopping_cart ") -> SET("
                        cnt ") -> where(" User_id = ".$_SESSION['id']) ->
                        whereAnd(" Book_id = $id ") -> insertUpdate($cnt);
                    header("Location: /~user8/book_shop/");
                    return true;
                }
            }
            $arr = array($_SESSION['id'], $id, 1);
            $this -> DBmodel -> INSERT(" shopping_cart ") -> keys(" User_id,
                Book_id, cnt ") -> values(" ?, ?, ? ") -> insertUpdate($arr);
            header("Location: /~user8/book_shop/");
            return true;
        }
    }
// select and return cart items for logged user
    public function cartItems($id)
    {
        $result = $this -> DBmodel -> SELECT (" c.Book_id, c.cnt, b.title,
            b.price, d.discount ") -> from(" shopping_cart c ") -> inner(" books
            b ") -> on(" c.Book_id = b.id ") -> inner(" disc_user du ") -> on("
            du.id_user = c.User_id ") -> inner(" discount d ") -> on(" d.id =
            du.id_disc ") -> where(" c.User_id = $id ") -> selected();
        return $result;
    }
// remove item from cart
    public function removeFromCart($id)
    {
        $this -> DBmodel -> DELETE(" shopping_cart ") -> where("Book_id = $id ")
            -> whereAnd(" User_id = ".$_SESSION['id']) -> deleted();
        header("Location: /~user8/book_shop/cart");
        return true;
    }
// decreases book count in cart
    public function setCount($id)
    {
        $result = $this -> DBmodel -> SELECT(" Book_id, cnt ") -> from("
        shopping_cart ") -> where(" User_id = ".$_SESSION['id']) -> selected();
        foreach($result as $value)
        {
            if($value['Book_id'] == $id)
            {
                $cnt = array($value['cnt']-1);
                $this -> DBmodel -> UPDATE(" shopping_cart ") -> SET(" cnt ")
                    -> where(" User_id = ".$_SESSION['id']) -> whereAnd("
                    Book_id = $id ") -> insertUpdate($cnt);
                header("Location: /~user8/book_shop/cart");
                return true;
            }
        }
    }
// select and return payment type
    public function getPayment()
    {
        $result = $this -> DBmodel -> SELECT(" id, payment_type ") -> from("
            payment ") -> selected();
        return $result;
    }
// transfers cart to orders
    public function sendOrder($pay, $user, $summ, $cart )
    {
        $arr = array($user, $pay, $summ);
        $this -> DBmodel -> INSERT(" orders ") -> keys(" user_id, payment_id, summ ")
            -> values(" ?, ?, ? ") -> insertUpdate($arr);
        $id = $this -> DBmodel -> getLastInsertId();
        foreach($cart as $v)
        {
            $ar = array($id, $v['Book_id'], $v['cnt'], $v['price']);
            $this -> DBmodel -> INSERT(" orders_help ") -> keys(" orders_id, book_id, cnt, price ")
                -> values(" ?, ?, ?, ? ") -> insertUpdate($ar);
        }
        $this -> deleteCart($user);
        return true;
    }
// delete books from cart after transfers
    public function deleteCart($id)
    {
        $this -> DBmodel -> DELETE(" shopping_cart ") -> where(" User_id = $id ") -> deleted();
        return true;
    }
}
?>
