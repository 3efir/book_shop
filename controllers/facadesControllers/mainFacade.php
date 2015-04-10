<?php
class mainFacade
{
    private $DBmodel;
    public function __construct()
    {
        $this -> DBmodel = DataBase::getInstance();
    }
    public function allBooks()
    {
        $result = $this -> DBmodel -> SELECT(" b.id, b.title, b.img, b.price,
            GROUP_CONCAT(distinct a.name SEPARATOR ', ') as name, GROUP_CONCAT(distinct
            g.genre SEPARATOR ', ') as genre ") -> from(' books b ') -> left('
            autor_book ab ') -> on(' ab.id_book = b.id ') -> left(' book_genre bg
            ') -> on(' bg.id_book = b.id ') -> left(' autor a ') -> on('
            a.id = ab.id_autor ') -> left(' genre g ') -> on(' g.id = bg.id_genre
            ') -> GROUP(' b.id ') -> selected();
        return $result;
    }
    public function allAutors()
    {
        $result = $this -> DBmodel -> SELECT(" id, name ") -> from(" autor ")
            -> selected();
        return $result;
    }
    public function allGenres()
    {
        $result = $this -> DBmodel -> SELECT(" id, genre ") -> from(" genre ")
            -> selected();
        return $result;
    }
    public function getBooksByAutor($id)
    {
        $result = $this -> DBmodel -> SELECT(" b.id, b.title, b.img, b.price,
            GROUP_CONCAT(distinct a.name SEPARATOR ', ') as name, GROUP_CONCAT(distinct
            g.genre SEPARATOR ', ') as genre ") -> from(' books b ') -> left('
            autor_book ab ') -> on(' ab.id_book = b.id ') -> left(' book_genre bg
            ') -> on(' bg.id_book = b.id ') -> left(' autor a ') -> on('
            a.id = ab.id_autor ') -> left(' genre g ') -> on(' g.id = bg.id_genre
            ') -> where(" a.id = ".$id) -> GROUP(' b.id ') -> selected();
        return $result;
    }
    public function getBooksByGenre($id)
    {
        $result = $this -> DBmodel -> SELECT(" b.id, b.title, b.img, b.price,
            GROUP_CONCAT(distinct a.name SEPARATOR ', ') as name, GROUP_CONCAT(distinct
            g.genre SEPARATOR ', ') as genre ") -> from(' books b ') -> left('
            autor_book ab ') -> on(' ab.id_book = b.id ') -> left(' book_genre bg
            ') -> on(' bg.id_book = b.id ') -> left(' autor a ') -> on('
            a.id = ab.id_autor ') -> left(' genre g ') -> on(' g.id = bg.id_genre
            ') -> where(" g.id = ".$id) -> GROUP(' b.id ') -> selected();
        return $result;
    }
    public function getBook($id)
    {
        $result = $this -> DBmodel -> SELECT(" b.id, b.title, b.img, b.price,
            GROUP_CONCAT(distinct a.name SEPARATOR ', ') as name, GROUP_CONCAT(distinct
            g.genre SEPARATOR ', ') as genre ") -> from(' books b ') -> left('
            autor_book ab ') -> on(' ab.id_book = b.id ') -> left(' book_genre bg ')
            -> on(' bg.id_book = b.id ') -> left(' autor a ') -> on(' a.id =
            ab.id_autor ') -> left(' genre g ') -> on(' g.id = bg.id_genre ') ->
            where(" b.id = ".$id) -> GROUP(' b.id ') -> selected();
        return $result;
    }
    public function getOrders()
    {

    }
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
    public function addToCart($id)
    {
        $result = $this -> DBmodel -> SELECT(" Book_id, cnt ") -> from("
            shopping_cart ") -> where(" User_id = ".$_SESSION['id']) -> selected();
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
    public function cartItems($id)
    {
        $result = $this -> DBmodel -> SELECT (" c.Book_id, c.cnt, b.title,
            b.price, d.discount ") -> from(" shopping_cart c ") -> inner(" books
            b ") -> on(" c.Book_id = b.id ") -> inner(" disc_user du ") -> on("
            du.id_user = c.User_id ") -> inner(" discount d ") -> on(" d.id =
            du.id_disc ") -> where(" c.User_id = $id ") -> selected();
        return $result;
    }
    public function removeFromCart($id)
    {
        $this -> DBmodel -> DELETE(" shopping_cart ") -> where("Book_id = $id ")
            -> whereAnd(" User_id = ".$_SESSION['id']) -> deleted();
        header("Location: /~user8/book_shop/cart");
        return true;
    }

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
    public function getPayment()
    {
        $result = $this -> DBmodel -> SELECT(" id, payment_type ") -> from("
            payment ") -> selected();
        return $result;
    }
    
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
    public function deleteCart($id)
    {
        $this -> DBmodel -> DELETE(" shopping_cart ") -> where(" User_id = $id ") -> deleted();
        return true;        
    }
}
?>
