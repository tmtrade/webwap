<?
/**
 * 商标页面
 *
 * @package     Action
 * @author      Xuni
 * @since       2016-07-13
 */
class TrademarkAction extends AppAction
{
    public $caches      = array('trademar');
    public $cacheId     = 'redisHtml';
    public $expire      = 3600;//1小时

    public function index()
    {
	//获得参数
	$params['name']   = $this->input('name', 'string', '');
        $page = $this->input('page','int',1);
        //得到分页数据
	$res = $this->load('sale')->getList($params, $page, $size);
        $count = $res['total'];
        $data = $res['rows'];
        //得到分页工具条
        $pager 	= $this->pagerNew($count, $size);
        $pageBar 	= empty($data) ? '' : getPageBarNew($pager);
        $this->set("pageBar",$pageBar);
        $this->set("list",$data);
//	echo "<pre>";
//	print_r($data);
	$this->set("s",$params);
        $this->display();
    }
    
    public function detail()
    {
	$this->set('list',$list);
        $this->display();
    }

}
?>