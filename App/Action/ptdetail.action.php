<?php
/**
 * Created by PhpStorm.
 * User: dower
 * Date: 2016/7/19 0019
 * Time: 下午 14:48
 */
class PtdetailAction extends AppAction{
    public $ptype       = 11;
    /**
     * 设置标题
     * @param $data
     * @return string
     */
    private function getTitle($data)
    {
        $title = $data['name']."_".$data['class']."类_"."专利转让|买卖|交易|价格 – 一只蝉商标专利转让平台网";
        $keywords = $data['name'].'专利转让,'.$data['class'].'类专利转让'.',商标转让,注册商标交易买卖';
        $description = $data['name'].','.$data['class'].'类专利转让交易买卖价格信息。购买专利商标到一只蝉商标交易平台第一时间获取商标价格信息,一只蝉商标转让平台网-独家签订交易损失赔付保障协议商标交易买卖平台';
        return array("title"=>$title,"keywords"=>$keywords,"description"=>$description);
    }

    /**
     * 专利详情页
     */
    public function index(){
        //获取参数
        $number = $this->input('short', 'string', '');
        $number = ltrim($number,'-');
        $number = strtolower($number);
        //获得专利基本信息
        $info = $this->load('pdetail')->getPatentInfo($number,false);
        //得到专利包装信息
        $isSale = true;
        if($info){
            $tminfo = $this->load('pdetail')->getSaleTminfo($info['id']);
            if($info['status']!=1){ //下架
                $isSale = false;
            }
        }else{
            //包装信息为空
            $tminfo = array();
            //获得万象云的原始数据
            $info = $this->load('pdetail')->getOrginalInfo($number,2);
        }
        if ( empty($info)){
            $this->redirect('未找到相关专利', '/index/error');
        }
        //设置专利信息相关
        $info['viewPhone'] = empty($info['viewPhone']) ? '18602868321' : $info['viewPhone'];
        $info['thum_title'] = mbSub($info['title'],0,30);
        if($info['type']!=3){ //转换字符为ascii
            $classArr = explode(",", $info['class']);
            $_class = array_map('chr', $classArr);
            $info['class'] = implode(',', $_class);
        }
        //得到相关参数
        $patentType 	= C("PATENT_TYPE");//专利类别
        $patentClassOne	= C("PATENT_ClASS_ONE");//行业分类
        $patentClassTwo	= C("PATENT_ClASS_TWO");//行业分类
        //设置标题
        $title['name'] 	= $info['title'];
        $title['class']	= $patentType[$info['type']];
        //设置SEO
        $seoList = $this->getTitle($title);
        $this->set('title', $seoList['title']);
        $this->set('keywords', $seoList['keywords']);
        $this->set('description', $seoList['description']);
        //得到用户订单的need字段
        $need = "专利号:".$number;
        //得到推荐专利
        $tj = $this->load('pdetail')->getRandPT(2);
        //分配数据
        $this->set('patentType', $patentType);
        $this->set('patentClassOne', $patentClassOne);
        $this->set('patentClassTwo', $patentClassTwo);
        $this->set("info", $info);
        $this->set("isSale", $isSale);
        $this->set("tminfo", $tminfo);
        $this->set("need", $need);
        $this->set("tj", $tj);
        $this->set("number", $number);
        $this->set("page_title", '专利详情');
        $this->display();
    }
}