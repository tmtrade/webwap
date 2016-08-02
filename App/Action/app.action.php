<?
/**
 * 应用公用控制器
 *
 * 存放应用的公共方法
 *
 * @package     Action
 * @author      Xuni
 * @since       2016-07-13
 */
abstract class AppAction extends Action
{
    /**
     * 每页显示多少行
     */
    public $rowNum      = 10;
    public $username     = '';
    public $userId       = '';
    public $isLogin      = false;
    public $pageTitle     = '商标转让-百万注册商标转让交易买卖平台- 一只蝉商标转让平台网';
    public $pageKey     = '商标转让,一只蝉,商标转让网,注册商标转让,转让商标,商标买卖,商标交易,商标交易网';
    public $pageDescription = '商标转让上一只蝉商标转让平台网,一只蝉是超凡集团商标交易平台：13年积累约200余万商标转让信息-也是中国独家签订交易损失赔付协议保障风险平台。提供专业的商标交易,商标买卖等服务';
    public $seotime = "一只蝉商标转让平台网";
    public $ptype = 0;

    /**
     * 前置操作(框架自动调用)
     * @author      Xuni
     * @since       2016-07-13
     *
     * @access    public
     * @return    void
     */
    public function before()
    {
	$this->caches = ""; //打开后关闭所有 页面缓存
        //设置用户信息
        $this->setLoginUser();
        $this->set('_mod_', $this->mod);
        $this->set('_action_', $this->action);

        $this->set('title', $this->pageTitle);//页面title
        $this->set('keywords', $this->pageKey);//页面keywords
        $this->set('description', $this->pageDescription);//页面description
        $this->set('ptype',$this->ptype);//设置页面标识
        $this->set('static_version', 11401);//静态文件版本号>>控制js,css缓存
    }

    /**
     * 后置操作(框架自动调用)
     * @author    void
     * @since    2015-01-28
     *
     * @access    public
     * @return    void
     */
    public function after()
    {
        //自定义业务逻辑
    }

    /**
     * 输出json数据
     *
     * @author    Xuni
     * @since    2015-11-06
     *
     * @access    public
     * @return    void
     */
    protected function returnAjax($data=array())
    {
        $jsonStr = json_encode($data);
        exit($jsonStr);
    }

    /**
     * 设置用户信息数据
     *
     * @author    Xuni
     * @since    2015-11-06
     *
     * @access    public
     * @return    void
     */
    protected final function setLoginUser()
    {
        if ( empty($_COOKIE['uc_ukey']) ){
            $this->removeUser();
            return false;
        }else{
            $this->loginId      = $_COOKIE['uc_identify'];
            $this->nickname     = $_COOKIE['uc_nickname'];
            $this->userMobile   = $_COOKIE['uc_mobile'];
            $this->isLogin      = true;
        }

        //设置用户信息到页面
        $this->setUserView();
    }

    /**
     * 设置用户信息数据到页面
     *
     * @author    Xuni
     * @since    2015-11-06
     *
     * @access    public
     * @return    void
     */
    protected final function setUserView()
    {
        $this->set('nickname', $this->nickname);
        $this->set('loginId', $this->loginId);
        $this->set('userMobile', $this->userMobile);
        $this->set('isLogin', $this->isLogin);
    }
        
    /**
     * 删除用户信息数据
     *
     * @author    Xuni
     * @since    2015-11-06
     *
     * @access    public
     * @return    void
     */
    protected final function removeUser()
    {
        $this->loginId      = '';
        $this->nickname     = '';
        $this->userMobile   = '';
        $this->isLogin      = false;

        //设置用户信息到页面
        $this->setUserView();
    }

    /**
     * 获取输入参数
     *
     * @access    protected
     * @param    string    $name    参数名
     * @param    string    $type    参数类型
     * @param    int        $length    参数长度(0不切取)
     * @return    mixed(int|float|string|array)
     */
    protected function getParam($name, $type = 'string', $length = 0)
    {
        $types = array('int', 'float', 'array', 'string');
        if ( !in_array($type, $types) )
        {
            return '';
        }

        $value = isset($this->input[$name]) ? $this->input[$name] : '';
        
        if ( empty($value) )
        {
            if ( $type == 'string' )
            {
                return '';
            }

            if ( $type == 'array' )
            {
                return array();
            }
        }

        if ( $type == 'int' )
        {
            return intval($value);
        }

        if ( $type == 'float' )
        {
            return $length == 0 
                ? sprintf("%.2f", floatval($value)) 
                : sprintf("%.{$length}f", floatval($value));
        }

        if ( $type == 'array' )
        {
            return $value;
        }

        $length = $length ? intval($length) : 0;
        return $length ? substr($value, 0, $length) : $value;             
    }


}
?>