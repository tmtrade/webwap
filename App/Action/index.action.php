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
        $this->display();
    }

    public function searchLog()
    {
        $title  = $this->input('title','string','');

        $prefix = C('SEARCH_HISTORY');
        $log    = (array)unserialize( Session::get($prefix) );
        $list   = array_slice($log, 0, 10);
        
        $this->set('list',$list);
        $this->display();
    }

    /**
     * 发送邮件
     */
    public function sendEmail(){
        //准备数据
        $contact    = $this->input('contact','string','');
        $content    = $this->input('content','string','无');
        $content    .= '<br/>'.'<font color="red">联系方式:</font> '.$contact;
        $email      = C('FEEDBACKER');
        $title      = '一只蝉反馈意见';
        $name       = '';
        $from       = '一只蝉';
        //发送邮件
        $res = $this->load('index')->sendEmail($email, $title, $content, $name , $from);
        return $this->returnAjax($res);
    }
}
?>