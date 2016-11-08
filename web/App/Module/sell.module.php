<?php
/**
 * Created by PhpStorm.
 * User: dower
 * Date: 2016/7/19 0019
 * Time: 下午 14:56
 */
class SellModule extends AppModule{
    /**
     * 引用业务模型
     */
    public $models = array(
        'contact' => 'saleContact',
        'sale' => 'sale',
        'tm' => 'trademark',
        'second' => 'secondstatus',
    );

    /**
     * 商标字段
     */
    protected $col = array(
        'auto as `tid`', 'id as `number`',
        'trademark as `name`', '`class`', 'pid', 'reg_date',
        'valid_end', '`goods`', '`group`',
    );

    /**
     * 检测用户是否具有提交了该商标信息
     * @param $number
     * @param $phone
     * @return bool
     */
    public function existContact($number,$phone){
        //组装参数
        if ( empty($number) ) return false;
        $r['eq'] = array('number'=>$number,'phone'=>$phone);
        //查询
        $count = $this->import('contact')->count($r);
        return ($count > 0) ? true : false;
    }

    /**
     * 得到商标的信息
     * @param $number
     * @param $type 1添加状态信息
     * @return array|mixed
     */
    public function getTmInfo($number,$type = 0){
        //得到基础商标信息
        $r['eq']    = array('id' => $number);
        $r['col']   = $this->col;
        $r['limit'] = 100;
        $data       = $this->import('tm')->find($r);
        if(empty($data)) return array();
        //得到商标状态
        $info   = current($data);
        if(empty($info) || empty($info['tid'])) return array();
        $info['class'] = implode(',',arrayColumn($data,'class'));//合并分类
        if($type){
            $info['second'] = $this->getSecond($info['tid']);
        }
        return $info;
    }

    /**
     * 商标二级状态
     * @param $tid
     * @return array
     */
    public function getSecond($tid){
        if ( intval($tid) <= 0 ) return array();
        $r['eq']    = array('tid'=>$tid);
        $second     = $this->import('second')->find($r);
        if ( empty($second) ) return array();
        $list       = array();
        $Seconds    = C("SecondStatus");
        foreach (range(1, 28) as $v) {
            $key = 'status'.$v;
            if ($second[$key] == 1){
                $list[$v] = $Seconds[$v];
            }
        }
        return $list;
    }

    /**
     * 商标是否在销售中
     * @param $number
     * @return bool
     */
    public function existSale($number){
        if ( empty($number) ) return false;
        $r['eq']    = array('number'=>$number);
        $r['col']   = array('id');
        $res = $this->import('sale')->setCache(false)->find($r);
        if ( empty($res) ) return false;
        return $res['id'];
    }

}