<?php
/**
 * Created by PhpStorm.
 * User: dower
 * Date: 2016/7/19 0019
 * Time: 下午 14:48
 */
class PtsearchAction extends AppAction{

    private $row_num = 8;

    /**
     * 获取列表
     */
    public function index(){
        //获得参数
        $kw = $this->input('kw', 'string', '');
        $type = $this->input('t', 'string', '');
        $class = $this->input('c', 'string', '');
        $page = $this->input('page','int',1);
        //解析数据
        $_type = array_filter( array_unique( explode(',', $type)));
        $_class = array_filter( array_unique( explode(',', $class)));
        //得到当前的url参数字符串的查询参数
        $_whereArr = array();
        $params = array();
        if($type){
            $_whereArr['t'] = $type;
            $params['type'] = count($_type) > 1 ? $_type : current($_type);
        }
        if($class){
            $_whereArr['c'] = $class;
            $params['class'] =implode(',', $_class);
        }
        if($kw){
            $_whereArr['kw'] = $kw;
            $params['kw'] = $kw;
        }
        //当前的参数串
        $whereStr = http_build_query($_whereArr);
        //得到数据
        $list = $this->load('pt')->getPtList($params, $page, $this->row_num);
        $ptType     = C('PATENT_TYPE');
        $ptOne      = C('PATENT_ClASS_ONE');
        $ptTwo      = C('PATENT_ClASS_TWO');
        if(count($_type) == 1){
            (current($_type)==3)?$this->set('_CLASS', $ptTwo):$this->set('_CLASS', $ptOne);
        }
        //设置标题文字
        list($t_title, $c_title) = $this->getWhereTitle($type, $class);
        $this->set('t_title', $t_title);
        $this->set('c_title', $c_title);
        //渲染页面
        $this->set('kw', $kw);
        $this->set('t_arr', $_type);
        $this->set('c_arr', $_class);
        $this->set('whereStr', $whereStr);
        $this->set('list', $list['rows']);
        $this->set('total', $list['total']);
        $this->set('p_size', $this->row_num);
        $this->set('_TYPE', $ptType);
        $this->display();
    }

    /**
     * 加载更多
     */
    public function getmore(){
        //获得数据
        $kw = $this->input('kw', 'string', '');
        $page   = $this->input('_p', 'int', 2);
        $type   = $this->input('t', 'string', '');
        $class  = $this->input('c', 'string', '');
        //解析类型和分类
        $kw = urldecode($kw);
        $_type  = array_filter( array_unique( explode(',', $type) ) );
        $_class = array_filter( array_unique( explode(',', $class) ) );
        //获取查询参数
        $params = array();
        if($type){
            $params['type'] = count($_type) > 1 ? $_type : current($_type);
        }
        if($class){
            $params['class'] =implode(',', $_class);
        }
        if($kw){
            $params['kw'] = $kw;
        }
        //得到专利数据
        $res = $this->load('pt')->getPtList($params, $page, $this->row_num);
        $this->set('list', $res['rows']);
        $this->display();
    }

    /**
     * 得到筛选后的标题
     * @param $type
     * @param $class
     * @return array
     */
    protected function getWhereTitle($type, $class){
        $ptType     = C('PATENT_TYPE');
        $ptOne      = C('PATENT_ClASS_ONE');
        $ptTwo      = C('PATENT_ClASS_TWO');
        $_type      = array_filter( array_unique( explode(',', $type) ) );
        $_class     = array_filter( array_unique( explode(',', $class) ) );
        $_className = $_typeName = array();
        if ( count($_type) == 1 ){
            $_ty = current($_type);
            array_push($_typeName, $ptType[$_ty]);
            foreach ($_class as $k => $v) {
                $_ty == 3 ? array_push($_className, $ptTwo[$v]) : array_push($_className, $ptOne[$v]);
            }
        }else{
            foreach ($_type as $k => $v) {
                array_push($_typeName, $ptType[$v]);
            }
        }
        return array(implode(',', $_typeName), implode(',', $_className));
    }
}