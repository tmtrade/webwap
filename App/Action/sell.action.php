<?php
/**
 * Created by PhpStorm.
 * User: dower
 * Date: 2016/7/19 0019
 * Time: 下午 14:48
 */
class SellAction extends AppAction{

    /**
     * 渲染页面
     */
    public function index(){
        $this->set("page_title", '我要出售');
        $this->display();
    }

    /**
     * 检测商标状态
     * @param $number
     * @param $mobile
     * @return array|bool
     */
    private function check($number,$mobile){
        //判断用户是否已出售过
        $isSale         = $this->load("sell")->existContact($number,$mobile);
        if($isSale) return array('code'=>2,'msg'=>'您已经提交过该商标');
        //判断商标是否存在
        $info   = $this->load('sell')->getTmInfo($number,1);
        if ( empty($info) ) return array('code'=>3,'msg'=>'找不到对应商标，请查证重新输入');
        //不能出售的商标
        $status = array('商标已无效','冻结中');
        foreach ($status as $s) {
            if( in_array($s, $info['second']) ){
                return array('code'=>4,'msg'=>'该商标状态不适合出售');
            }
        }
        //正常状态结果
       return false;
    }

    /**
     * 添加商标出售数据
     */
    public function addsell(){
        //获取数据
        $number	= $this->input("number","string");
        $mobile	= $this->input("mobile","string");
        $price	= $this->input("price","string");
        if ( empty($number) || empty($mobile) || empty($price) ) $this->returnAjax(array('code'=>1,'msg'=>'数据不完整'));
        //检测商标能否出售
        $res = $this->check($number,$mobile);
        if($res){
            $this->returnAjax($res);
        }
        //判断商标是否为商品
        $saleId = $this->load('sell')->existSale($number);
        //得到联系人的用户id
        $uid = 0;
        if($this->loginId) $uid = $this->loginId;
        if($saleId){
            //追加联系人信息
            $res = $this->add_contact($saleId,$number,$price,$mobile,$uid);
            if(!$res){
                $this->returnAjax(array('code'=>5,'msg'=>'添加联系信息失败'));
            }
        }else{
            //添加商品
            $res = $this->add_goods($saleId,$number,$price,$mobile,$uid);
            if(!$res){
                $this->returnAjax(array('code'=>6,'msg'=>'添加商标信息失败'));
            }
        }
        $this->returnAjax(array('code'=>0));
    }

    /**
     * 添加商品
     * @param $number
     * @param $price
     * @param $phone
     * @param $uid
     * @return bool
     */
    private function add_goods($number,$price,$phone,$uid){
        //商标信息
        $info   = $this->load('trademark')->getTmInfo($number);
        if ( empty($info) ) return false;
        //商标其他信息
        $other  = $this->load('trademark')->getTmOther($number);
        if ( empty($other) ) return false;

        $class      = implode(',', $info['class']);
        $memo 		= count($info['class']) > 1 ? '(该商标为一标多类，必须捆绑出售)' : '';
        $platform   = implode(',', $other['platform']);
        $viewPhone  = $this->load('phone')->getRandPhone();
        $regDate    = strtotime($info['reg_date']) > 0 ? strtotime($info['reg_date']) : 0;
        $sale = array(
            'tid'           => intval($info['tid']),
            'number'        => $number,
            'class'         => $class,
            'group'         => trim($info['group']),
            'name'          => trim($info['name']),
            'pid'           => intval($info['pid']),
            'price'         => 0,
            'priceType'     => 2,//议价
            'isOffprice'    => 2,
            'salePrice'     => 0,
            'salePriceDate' => 0,
            'status'        => 3, //待审核
            'isSale'        => 1,//出售
            'isLicense'     => 2,
            'isTop'         => 0,
            'type'          => $other['type'],
            'platform'      => $platform,
            'label'         => '',
            'length'        => $other['length'],
            'regDate'       => $regDate,
            'date'          => time(),
            'hits'          => 0,
            'viewPhone' 	=> $viewPhone,
            'memo'          => '一只蝉前台创建商品'.$memo,
        );
        $tminfo = array(
            'number'    => $number,
            'memo'      => '一只蝉前台创建默认包装信息',
            'intro'     => '',
        );
        $contact = array(
            'source'        => 13,
            'uid'           => $uid,
            'tid'           => intval($info['tid']),
            'number'        => $number,
            'name'          => '',
            'phone'         => $phone,
            'price'         => $price,
            'saleType'      => 1,
            'isVerify'      => 2,
            'advisor'       => '',
            'department'    => '',
            'date'          => time(),
            'memo'      	=> '一只蝉前台创建联系人',
        );
        $_data = array(
            'sale' 			=> $sale,
            'saleTminfo'	=> $tminfo,
            'saleContact'	=> $contact,
        );
        $saleId = $this->load('internal')->addAll($_data);
        return $saleId;
    }

    /**
     * 添加联系人
     * @param $saleId
     * @param $number
     * @param $price
     * @param $phone
     * @param $uid
     * @return bool
     */
    private function add_contact($saleId,$number,$price,$phone,$uid){
        //商标信息
        $info = $this->load('trademark')->getTmInfo($number);
        if ( empty($info) || empty($info['tid']) ) return false;
        $contact = array(
            'source'        => 13,
            'uid'           => intval($uid),
            'tid'           => intval($info['tid']),
            'number'        => $number,
            'phone'         => $phone,
            'price'         => $price,
            'saleType'      => 1,
            'isVerify'      => 2,
            'advisor'       => '',
            'department'    => '',
            'date'          => time(),
            'memo'      	=> '一只蝉前台添加联系人',
        );
        return $this->load('internal')->addContact($contact, $saleId);
    }

    /**
     * 添加专利数据
     */
    public function addPtSell(){
        //获取数据
        $number	= $this->input("number","string");
        $mobile	= $this->input("mobile","string");
        $price	= $this->input("price","string");
        if ( empty($number) || empty($mobile) || empty($price) ) $this->returnAjax(array('code'=>1,'msg'=>'数据不完整'));
        //判断专利是否存在
        $info = $this->load('patent')->getPatentInfoByWanxiang($number,2);
        if ( empty($info['id']) ) $this->returnAjax(array('code'=>2,'msg'=>'找不到对应的专利数据'));
        //判断商标是否为商品
        $saleId = $this->load("patent")->existSale($number);
        //得到联系人的用户id
        $uid = 0;
        if($this->loginId) $uid = $this->loginId;
        //联系人数据
        $dataContat = array();
        $code   = (strpos($number, '.') !== false) ? strstr($number, '.', true) : $number;
        $dataContat['source']       = 13;
        $dataContat['phone']        = $mobile;
        $dataContat['saleType']     = 1;
        $dataContat['number']       = $number;
        $dataContat['code']         = $code;
        $dataContat['price']        = $price;
        $dataContat['uid']          = $uid;
        $dataContat['isVerify']     = 2;
        $dataContat['date']         = time();
        if($saleId){
            //追加联系人信息
            $saleBContact = $this->load('patent')->getSaleContactByPhone($number,$mobile);
            //如果没有这个联系人，就写入这个联系人信息
            if(!$saleBContact){
                $dataContat['patentId']     = $saleId;
                $isOk = $this->load('patent')->addContact($dataContat,$saleId);
                if(!$isOk){
                    $this->returnAjax(array('code'=>3,'msg'=>'添加联系信息失败'));
                }
            }else{
                $this->returnAjax(array('code'=>5,'msg'=>'您已经提交过该专利'));
            }
        }else{
            //添加商品
            $info = $this->load('patent')->getPatentInfoByWanxiang($number);
            $isOk = $this->load('patent')->addDefault($number,$info,$dataContat);
            if(!$isOk){
                $this->returnAjax(array('code'=>4,'msg'=>'添加商标信息失败'));
            }
        }
        $this->returnAjax(array('code'=>0));
    }
}