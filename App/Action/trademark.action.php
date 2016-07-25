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
		$issale = 0;
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
		//分配数据
		$this->set("info", $info);
		$this->set("sale", $sale);
		$this->set("need", $need);
		$this->set("topic", $topic);
		$this->set("refer", $refer);
		$this->set("class", $class);
		$this->set("isSale", $isSale);
		$this->set("platform", $platform);
		$this->display();
    }

}
?>