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
	$this->set('list',$list);
        $this->display();
    }

}
?>