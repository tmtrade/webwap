<?php
/**
 * Created by PhpStorm.
 * User: dower
 * Date: 2016/7/19 0019
 * Time: 下午 14:48
 */
class BuyAction extends AppAction{
    public $ptype = 12;
    public $pageTitle 	= '买商标,商标交易,购买商标,哪里可以购买商标,买卖商标哪里好_一只蝉商标交易转让网';
    public $pageKey 	= '买商标,购买商标,商标交易,商标买卖,哪里可以购买商标，买卖商标公司,买卖商标哪里好';
    public $pageDescription = '一只蝉商标交易网是国内领先的商标交易平台，最权威的商标转让机构。买商标为你快速入驻天猫,京东等电商平台。买卖商标哪里好？一只蝉13年专业经验,为买卖商标创造一个快速安全专业的商标交易平台。';

    /**
     * 加载页面
     */
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
            //if(empty($enquiry)){
                $res = $this->load('phoneEnquiry')->sendMsg($phone);
                if($res){
                    $this->com('redisHtml')->set('enquiry'.$phone, 1, 86400);
                }
            //}
        }
        $this->returnAjax(array('code'=>1));
    }
}