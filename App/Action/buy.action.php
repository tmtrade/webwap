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
    
    /**
     * 立即咨询
     */
    public function enquiry(){
        //获取数据
        $number	= $this->input("number","string");
        $phone	= $this->input("phone","string");
        $type	= $this->input("type","int",1);
        if ( empty($number) || empty($phone) || empty($type) ) $this->returnAjax(array('code'=>2,'msg'=>'数据不完整'));
        //检测该用户是否已存在
        $phone_info = $this->load('phoneEnquiry')->getUserByPhone($phone);
        if(!empty($phone_info)){
            $this->returnAjax(array('code'=>2,'msg'=>'用户已存在'));
        }
        
        //添加记录到数据库
        $res= $this->load('phoneEnquiry')->addPhone($number,$phone,$type);
        //发送短信
        if($res){
            $enquiry = $this->com('redisHtml')->get('enquiry'.$phone);
            if(empty($enquiry)){
               // $this->load('phoneEnquiry')->sendMsg($phone);
                $this->com('redisHtml')->set('enquiry'.$phone, 1, 86400);
            }
        }
        $this->returnAjax(array('code'=>1));
    }
}