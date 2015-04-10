<?php
class OrdersModel
{
    protected $DB;
    public function __construct()
    {
        $this -> DB = DataBase::getInstance();
    }
    public function test($user='')
    {
        //echo $file = dirname(__FILE__);
        $file = file_get_contents('/usr/home/user8/public_html/book_shop/resources/templates/collapse.html');
        $result = '';
        if($user !== '')
        {
            $orders = $this -> DB -> SELECT (" o.id, o.data_time, o.summ, p.payment_type, s.name ") ->
            from(" orders o ") -> inner(" payment p ") -> on(" o.payment_id = p.id ") ->
            inner(" status s ") -> on(" s.id = o.status ") -> where(" o.user_id = $user ") ->
            order(" o.id desc ") -> selected();
        }
        else
        {
            $orders = $this -> DB -> SELECT (" o.id, o.data_time, o.summ, p.payment_type, s.name, o.user_id ") ->
            from(" orders o ") -> inner(" payment p ") -> on(" o.payment_id = p.id ") ->
            inner(" status s ") -> on(" s.id = o.status ") -> order(" o.id desc ") -> selected(); 
        }
        $oh = array();
        foreach ($orders as $v)
        {
            $oh[$v['id']] = $this -> DB -> SELECT (" oh.cnt, oh.price, b.title
                ") -> from(" orders_help oh ") -> inner(" books b ") -> on("
                oh.book_id = b.id ") -> where (" oh.orders_id = ".$v['id'])
                -> selected();
        }
        foreach($orders as $value)
        {
            $arr['%HREF%'] = $value['id'];
            $arr['%TITLE%'] = "DATA: ".$value['data_time']." | SUMM: ".$value['summ']." | STATUS: ".$value["name"];
            $body = '';
            foreach($oh[$value['id']] as $v)
            {
                $body .= "BOOK: ".$v['title']." | COUNT: ".$v['cnt']." | PRICE: ".$v['price']."<hr>";
            }
            if('' == $user)
            {
                $body .= "<a href='/~user8/book_shop/admin/setStatus/".$value['id']."'>Изменить статус</a>";
            }
            $arr['%BODY%'] = $body;
            $result .= FrontController::templateRender($file, $arr);

        }
        return $result;
    }
}
?>
