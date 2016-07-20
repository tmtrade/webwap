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
    public $caches      = array('trademar');
    public $cacheId     = 'redisHtml';
    public $expire      = 3600;//1小时
    
    
    public function index()
    {
	//获得参数
	$params['name']   = $this->input('name', 'string', '');
        $page = $this->input('page','int',1);
        //得到分页数据
	$res = $this->load('sale')->getList($params, $page, $this->rowNum);
	
        $this->set("list",$res['rows']);
	$this->set("counts",$res['total']);
	$this->set("s",$params);
	$this->set('has', empty($res['rows']) ? false : true);
        $this->display();
    }
    
    //获取更多的数据
    public function getMore()
    {
        $page   = $this->input('_p', 'int', 1);

        $res = $this->load('sale')->getList($params, $page, $this->rowNum);

        $this->set('searchList', $res['rows']);
        $this->display();
    }
    
    public function detail()
    {
	$this->set('list',$list);
        $this->display();
    }

}
?>