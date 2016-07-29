<?
/**
 * 商标页面
 *
 * @package     Action
 * @author      Far
 * @since       2016-07-20
 */
class TrademarkAction extends AppAction
{
    
    public function index()
    {
        
	//获得参数
	$params = $this->getFormData();
        $page = $this->input('page','int',1);
	
        //得到分页数据
	$res = $this->load('sale')->getList($params, $page, $this->rowNum);
        
        //设置页面TITLE
        $seoList = $this->load('trademark')->getSeo($params);
        if(!empty($seoList['title'])){
            $this->set('title', $seoList['title']);
            $this->set('description', $seoList['description']);
        }
        
        //存储每个用户当次的搜索条件为下次搜索去比较
        $ip =  getClientIp();
        $this->com('redisHtml')->set('kw_'.$ip, $params, 300);
            
        $this->set("list",$res['rows']);
	$this->set("counts",$res['total']);
	$this->set('_CLASSES', C('CLASSES'));//商标分类
	$this->set('_NUMBER', C('SBNUMBER'));//商标字数
        $this->set('_TYPE', C('TYPES'));//组合类型
	$this->set("s",$params);
	$this->set('has', empty($res['rows']) ? false : true);
        $this->set('head_type', 1);
        $this->display();
    }
    
    //获取更多的数据
    public function getMore()
    {
	//获得参数
	$params = $this->getFormData();
        $page   = $this->input('_p', 'int', 1);

        $res = $this->load('sale')->getList($params, $page, $this->rowNum);

        $this->set('searchList', $res['rows']);
        $this->display();
    }
    
    public function detail()
    {
                $tag = $this->input('short', 'string', '');
		//获取参数
		if ( $tag ){
			if ( strpos($tag, '-') === false ) $this->redirect('未找到页面1', '/index/error');
			list($tid, $class) = explode('-', $tag);
		}else{
			$this->redirect('未找到页面2', '/index/error');
		}
		//获得商标号和分类
		$_info 	= $this->load('trademark')->getInfo($tid,array('`id` as `number`','class'));
		$number = $_info['number'];
                
		if ( empty($_info) || empty($number) ){
			$this->redirect('未找到页面3', '/index/error');
		}elseif( !in_array($class, range(1,45)) ){
			$this->redirect('未找到页面4', '/index/error');
		}
                
        
		//得到商标信息
		$info 	= $this->load('trademark')->getTmInfo($number);
		if ( empty($info) ){
			$this->redirect('未找到页面5', '/index/error');
		}
		if ( !in_array($class, $info['class']) ){
			$this->redirect('未找到页面6', '/index/error');
		}
                
		//得到商标的分类描述
		if(count($info['class']==1)){
			$res = $this->load('trademark')->getClassInfo($info['class'][0]);
                       
			if(empty($res['label'])){
				$info['label'] = $res['title'];
			}else{
				$info['label'] = $res['title'].': '.preg_replace('/,/','/',$res['label']);
			}
			$info['className'] = $res['name'];//分类名
			//处理商标名和分类描述的字符问题
			$info['thum_name'] = mbSub($info['name'],0,10);//10字符
			$info['thum_label'] = mbSub($info['label'],0,20);//20字符
		}
		//分配平台数据到页面
		$this->set("platformIn", C('PLATFORM_IN'));
		$this->set("platformUrl", C('PLATFORM_URL'));
		$this->set("platformItems", C('PLATFORM_ITEMS'));
		//商标是否出售,获取其他信息
		$tid 	= $info['tid'];
		$class 	= current($info['class']);
		$_class = implode(',', $info['class']);
		$other 	= $this->load('trademark')->getTmOther($number);//商标其他信息
		$saleId = $this->load('internal')->existSale($number);//是否出售
		if ( $saleId <= 0 ){//不是出售信息中的
			$platform 	= $other['platform'];
		}else{
			$sale 		= $this->load('internal')->getSaleInfo($saleId, 0, 1,false);
			$platform 	= explode(',', $sale['platform']);
		}
		//读取推荐商标
		 $refer	= $this->load("internal")->getReferrer($_class, 2, $number);
                 
                 //设置标题
		$title['name'] 	= $info['name'];
		$title['class']	= $class;
		$goods 			= current( explode(',', $info['goods']) );
                //设置SEO
                $seoList = $this->getTitle($title,$goods);
		$this->set('title', $seoList['title']);
                $this->set('keywords', $seoList['keywords']);
                $this->set('description', $seoList['description']);
                
		//分配数据
		$share_img = empty($info['imgUrl']['embellish'])?WAP_URL.StaticDir.'1.0/images/wap-banner.png':$info['imgUrl']['embellish'];
		//分配数据
		$this->set("share_img", $share_img);
		$this->set("info", $info);
		$this->set("sale", $sale);
		$this->set("refer", $refer);
		$this->set("class", $class);
		$this->set("platform", $platform);
                $this->set("page_title", '商标详情');
		$this->display();
    }
    
    private function getTitle($data,$goods)
	{
                list($cArr,) = $this->load('trademark')->getClassGroup(0, 0);
                $title = $data['name']."_".$data['class']."类_".$goods."商标转让|买卖|交易|价格 – 一只蝉商标转让平台网";
                $keywords = $data['name'].'商标转让,第'.$data['class'].'类'.$goods.' 商标转让,'.$cArr[$data['class']].'商标转让,商标转让,注册商标交易买卖';
                $description = $data['name'].'第'.$data['class'].'类'.$goods.'类'.$cArr[$data['class']].'商标转让交易买卖价格信息。购买商品名商标到一只蝉第'.$data['class'].'类'.$cArr[$data['class']].'商标交易平台第一时间获取'.$goods.'商标价格信息,一只蝉商标转让平台网-独家签订交易损失赔付保障协议商标交易买卖平台';
                return array("title"=>$title,"keywords"=>$keywords,"description"=>$description);
	}
}
?>