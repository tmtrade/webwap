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
	$name = $this->input('name', 'string', '');
        $this->display();
    }
    
    public function detail()
    {
	$this->set('list',$list);
        $this->display();
    }

}
?>