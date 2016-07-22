<?
/**
 * 专利筛选模块
 * @package Module
 * @author  Xuni
 * @since   2015-11-09
 */
class PtModule extends AppModule
{
    /**
     * 引用业务模型
     */
    public $models = array(
        'pt'          => 'patent',
    );

    /**
     * 得到专利数据
     * @param $params
     * @param int $page
     * @param int $limit
     * @param array $col
     * @return array
     */
    public function getPtList($params, $page=1, $limit=30, $col=array())
    {
        $r['raw'] = ' 1 ';
        //分类
        if ( !empty($params['type']) ){
            if ( is_array($params['type']) ){
                $r['in']['type'] = $params['type'];
            }else{
                $r['eq']['type'] = $params['type'];
                if ( !empty($params['class'])){
                    $_class = explode(',', $params['class']);
                    if($params['type'] != 3){
                        $r['ft']['class'] = implode(',', array_map('ord', $_class));
                    }else{
                        $r['ft']['class'] = implode(',', $_class);
                    }
                }
            }
        }
        $r['eq']['status']  = 1;
        $r['eq']['isSale']  = 1;
        //数据量较少,暂时可用like模糊查询
        if(!empty($params['kw'])){
            //是否检测专利号
            if(preg_match('/^([a-zA-Z]{2})?\d+(\.[\dxX])?$/',$params['kw'])){
                $r['raw'] = "`title` like '%{$params['kw']}%' or `number` like '%{$params['kw']}%'";
            }else{
                $r['raw'] = "`title` like '%{$params['kw']}%'";
            }
        }
        if ( empty($col) ){
            $r['col']   = array('id', 'number', 'code', 'class', 'type', 'title', 'price');
        }else{
            $r['col']   = $col;
        }
        $r['page']      = $page;
        $r['limit']     = $limit;
        $r['order']     = array('isTop' => 'desc');
        $res            = $this->import('pt')->findAll($r);
        $res['rows']    = $this->getListTips($res['rows']);
        return $res;
    }

    /**
     * 处理列表数据
     * @param $data
     * @return array
     */
    public function getListTips($data)
    {
        if ( empty($data) ) return array();
        if ( !is_array(current($data)) ){
            $_tmp = array($data);
        }else{
            $_tmp = $data;
        }
        foreach ($_tmp as $k => $v) {
            $data[$k] = $this->getTips($v);
        }
        return $data;
    }

    /**
     * 处理单个数据
     * @param $data
     * @param bool $img
     * @return mixed
     */
    public function getTips($data, $img=true)
    {
        $ptType     = C('PATENT_TYPE');
        $ptOne      = C('PATENT_ClASS_ONE');
        $ptTwo      = C('PATENT_ClASS_TWO');
        $_class     = array_filter( array_unique( explode(',', $data['class']) ) );
        $_classArr  = $_className = array();
        foreach ($_class as $k => $v) {
            if ( in_array($data['type'], array(1, 2)) ) {
                array_push($_classArr, chr($v));
                if ( isset($ptOne[chr($v)]) ) array_push($_className, $ptOne[chr($v)]);
            }else{
                array_push($_classArr, $v);
                if ( isset($ptTwo[$v]) ) array_push($_className, $ptTwo[$v]);
            }
        }
        $data['class']      = implode(',', $_classArr);
        $data['typeName']   = $ptType[$data['type']];
        $data['className']  = implode(',', $_className);
        if ($img) $data['imgUrl']     = $this->load('pdetail')->getPTImg($data['number']);
        return $data;
    }

}