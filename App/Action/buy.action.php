<?php
/**
 * Created by PhpStorm.
 * User: dower
 * Date: 2016/7/19 0019
 * Time: 下午 14:48
 */
class BuyAction extends AppAction{

    public function index(){
        $this->set("page_title", '购买登记');
        $this->display();
    }
}