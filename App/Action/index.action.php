<?
/**
 * 网站首页
 *
 * 网站首页
 *
 * @package     Action
 * @author      Xuni
 * @since       2016-07-13
 */
class IndexAction extends AppAction
{
    public $caches      = array('index');
    public $cacheId     = 'redisHtml';
    public $expire      = 3600;//1小时

    public function index()
    {
	$this->set('list',$list);
        $this->display();
    }

}
?>