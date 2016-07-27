<?php
/**
 * Created by PhpStorm.
 * User: dower
 * Date: 2016/3/3 0003
 * Time: 下午 15:55
 */
class SaleModule extends AppModule{
    public $models = array(
        'saleTminfo'	=> 'SaleTminfo',
        'sale'		=> 'Sale',
    );

        
    //获取列表数据
    public function getList($params, $page, $limit=20)
    {
        $r = array();
        $r['page']  = $page;
        $r['limit'] = $limit;
        $r['col']   = array('tid','class','number','name');
        $r['raw'] = ' 1 ';
	
        //分类
        if ( !empty($params['class']) && empty($params['group']) ){
            $r['ft']['class'] = $params['class'];
        }
        //组合类型
        if ( !empty($params['type']) ){
            $r['ft']['type'] = $params['type'];
        }
        //商标字数
        if ( !empty($params['length']) ){
            $r['ft']['length'] = $params['length'];
        }
	
        if ( !empty($params['name']) ){
           $_arr = array('keyword'=>$params['name']);
                    if ( !empty($params['class']) ){
                        $_arr['classId'] = $params['class'];
                    }
                    $_res = $this->searchLike($_arr, 1, 1000);
                    var_dump($_res['rows']);
                    if ( empty($_res['rows']) ) return $result;
                    $numberList = array_unique( arrayColumn($_res['rows'], 'code') );
                    if ( empty($numberList) ) return $result;
                    $r['in']['number'] = $numberList;
		    
		    $r['raw'] .= " OR `number`='{$params['name']}' ";
        } 
	$r['eq']['status']  = 1;
        $r['eq']['isSale']  = 1;
        $r['order']     = array('isTop' => 'desc');
	
        var_dump($numberList);exit;
        $res = $this->import('sale')->findAll($r);
	
	foreach($res['rows'] as &$v){
	    $v['pic'] = $this->getSaltTminfoByNumber($v['number']);
	}
	
        return $res;
    }
    
    

    /**
     * 近似查询调用
     *
     * @author  Xuni
     * @since   2016-03-04
     *
     * @return  array
     */
    public function searchLike($params, $page=1, $number=1000)
    {
        if ( empty($params) ) return array();

        $params['page']     = $page;
        $params['num']      = $number;

        $res = $this->importBi('trademark')->search($params);
        return $res;
    }
    
    /**
     * 根据商标得到tminfo
     * @author dower
     * @param $number
     * @param string $field
     * @return array|bool
     */
    public function getSaleTmByNumber($number){
        $r['eq'] = array('number'=>$number);
        $r['col']   = array('embellish');
        $info = $this->import('saleTminfo')->find($r);
        if($info==false){
            return false;
        }
        //返回包装数据
        if($info['embellish']){
            return TRADE_URL.$info['embellish'];
        }

        return $this->load('trademark')->getImg($number);
    }

    /**
     * 根据商标号得到商标的包装信息(无美化图,获得商标图)
     * @param $number
     * @return array|bool
     * @throws SpringException
     */
    public function getSaltTminfoByNumber($number){
        $r['eq'] = array('number'=>$number);
        $info = $this->import('saleTminfo')->find($r);
        //无销售数据
        if($info==false){
            $info = array();
            $info['alt1'] = '';
            $info['embellish'] = $this->load('trademark')->getImg($number);
            return $info;
        }
        //返回包装数据
        if($info['embellish']){
            $info['embellish'] = TRADE_URL.$info['embellish'];
        }else{
            $info['embellish'] = $this->load('trademark')->getImg($number);
        }

        return $info;
    }

    //获取商品信息
    public function getSaleInfo($number)
    {
        $arr['eq'] = array(
            'number' => $number,
            );
        $info = $this->import('sale')->find($arr);
        if ( empty($info) ) return array();
        return $info;
    }
    
}