<?
/**
* 商标相关信息
*
* 查询商标基础信息、图片、状态等
*
* @package	Module
* @author	Xuni
* @since	2015-10-22
*/
class TrademarkModule extends AppModule
{
    public $models = array(
        'img'		=> 'imgurl',
        'tm'		=> 'trademark',
        'third'		=> 'statusnew',
        'tminfo'        => 'saleTminfo',
        'class'         => 'tmClass',
        'kwcount'       => 'keywordCount',
    );

    protected $col = array(
        'auto as `tid`', 'id as `number`',
        'trademark as `name`', '`class`', 'pid', 'reg_date', 
        'valid_end', '`goods`', '`group`',
    );

    /**
     * 群组字符串替换处理
     * 
     * @author  Jeany
     * @since   2015-11-5
     * @access  public
     * @return  void
     */
    public function groupReplace($str) 
    { 
        $str = str_replace('　', ' ', $str); //替换全角空格为半角 
        $str = str_replace('<br>', ' ', $str); //替换BR
        $str = str_replace('\n', ' ', $str); //替换BR
        $str = str_replace('\r', ' ', $str); //替换BR
        $str = str_replace('&lt;br&gt;', ' ', $str); //替换BR
        $str = str_replace('*', '', $str);  //替换*
        $str = preg_replace('/\(.*?\)/', ' ', $str);//替换括号里面的
        $result = '';
        $strArr = explode(" ",$str);
        $strArr = array_unique(array_filter($strArr)); //去掉空字符串
        $result = implode(',', $strArr);
        return $result; 
    }
    
    /**
     * 获取商标名称类型
     * 
     * @author  Jeany
     * @since   2015-11-5
     * @access  public
     * @return  void
     */
    public function getTmType($name)
    {
        $name   = str_replace(" ","",$name);
        $pregtx = "图形";//图形验证正则
        $pregZW = "/^[\x7f-\xff]+$/"; //中文验证正则
        $pregYW = "/^[a-zA-Z]+$/";//英文验证正则
        $pregSZ = "/^[0-9]+$/";//数字
        
        $pregZWBH = "/[\x7f-\xff]/"; //包含中文
        $pregYWBH = "/[a-zA-Z]+/";//包含英文验证正则
        $pregSZBH = "/[0-9]+/";//包含数字
        $value    = 0;
        if(preg_match($pregZW,$name)  && !strstr($name,$pregtx)){ $value = 1;}//中文
        if(preg_match($pregYW,$name)){$value = 2;}//英文
        if($pregtx == $name){$value = 3;}//图形
        if(preg_match($pregZWBH,$name) && preg_match($pregYWBH,$name) && !strstr($name,$pregtx) && !preg_match($pregSZBH,$name)){$value = 4;}//中+英
        if(preg_match($pregZWBH,$name)  && strstr($name,$pregtx) && strlen($name) != 6 && !preg_match($pregSZBH,$name)){$value = 5;}//中+图
        $str = str_replace("图形","",$name);
        if(preg_match($pregYWBH,$name)  && strstr($name,$pregtx) && !preg_match($pregZWBH,$str)){$value = 6;}//英+图
        if(preg_match($pregZWBH,$name) && preg_match($pregYWBH,$name) && strstr($name,$pregtx)){$value = 7;}//中+英+图
        if(preg_match($pregSZ,$name)){$value = 8;}//数字
        
        return $value;
    }

    /**
     * 获取商标名称字数
     * 
     * @author  Jeany
     * @since   2015-11-5
     * @access  public
     * @return  void
     */
    public function getTmLength($name)
    {
        $name   = str_replace(" ","",$name);
        $strlen = 0;
        $pregZWBH = "/[\x{4e00}-\x{9fa5}]+/u"; //包含中文
        $pregSZBH = "/[0-9]/"; //包含数字
        $pregYWBH = "/[a-zA-Z]/u";//包含英文验证 

        //包含中文的，都按照中文计算
        if( preg_match($pregZWBH,$name) ){
            preg_match_all($pregZWBH, $name, $match);
            $str    = implode("",$match[0]);
            $strlen = mb_strlen($str, 'utf8');
        }elseif ( preg_match($pregYWBH,$name) ){//包含英文
            preg_match_all($pregYWBH, $name, $match);
            $strlen = count($match[0]);
        }elseif ( preg_match($pregSZBH,$name) ){//数字
            preg_match_all($pregSZBH, $name, $match);
            $strlen = count($match[0]);
        }else{//其他
            $strlen = mb_strlen($name, 'utf8');
        }

        $strlen = $strlen > 6 ? 6 : $strlen;
        return $strlen;
    }

    /**
     * 获取商标可入驻平台
     * 
     * @author  Jeany
     * @since   2015-11-5
     * @access  public
     * @return  void
     */
    public function getTmPlatform($class)
    {
        $strArr = array();
        $platform = C("PLATFORM_ITEMS");
        if ( is_array($class) ){
            foreach ($class as $c) {
                $resArr = $this->getTmPlatform($c);
                $strArr = array_merge($strArr, $resArr);
            }
        }else{
            foreach($platform as $key => $val){
                if(in_array($class, $val)){
                    $strArr[] = $key;  
                }
            }
        }
        $strArr = array_unique($strArr);
        return $strArr;
    }

    /**
    * 通过商标号获取商标信息
    */
    public function getTmInfo($number)
    {
        $r['eq']    = array('id' => $number);
        $r['col']   = $this->col;
        $r['limit'] = 100;
        $data       = $this->findTm($r);
        if(empty($data)) return array();

        $items    = array();
        $info   = current($data);
        $class  = arrayColumn($data, 'class');

        if(empty($info) || empty($info['tid'])) return array();
        foreach ($data as $k => $v) {
            $items[$k] = array(
                'class'     => $v['class'],
                'group'     => $this->groupReplace($v['group']),
                'goods'     => $v['goods'],
                );
        }

        $info['items']      = $items;
        $info['class']      = array_filter( $class );
        $info['imgUrl']     = $this->load("sale")->getSaltTminfoByNumber($number);
        
        $info['group']      = $this->groupReplace($info['group']);

        return $info;
    }

    //获取商标其他信息，如：字数，中英文，平台等
    public function getTmOther($number)
    {   
        $r['eq']    = array('id' => $number);
        $r['col']   = array('trademark as `name`', 'group_concat(distinct class) as `strclass`');

        $info       = $this->findTm($r);
        if(empty($info) || empty($info['strclass'])) return array();

        $res    = array();
        $class  = array_filter( explode(',', $info['strclass']) );

        $res['type']        = $this->getTmType($info['name']);
        $res['length']      = $this->getTmLength($info['name']);;
        $res['platform']    = $this->getTmPlatform($class);

        return $res;
    }

    //判断商标号是否存在 
    public function existTm($number)
    {
        $r['eq']    = array('id'=>$number);
        $r['col']   = array('id');

        $res = $this->findTm($r);
        if ( empty($res) || empty($res['id']) ) return false;
        return true;
    }

    /**
    * 获取商标tid（主键）
    *
    * @author   Xuni
    * @since    2015-10-22
    *
    * @access   public
    * @return   void
    */
    public function getTid($number, $class)
    {
        $r['eq'] = array(
            'id'    => $number,
            'class' => $class,
        );
        $r['col'] = array('auto as `tid`');
        $info = $this->findTm($r);
        return empty($info) ? '' : $info['tid'];
    }

    /**
    * 获取商标的基础model方法调用
    *
    * @author   Xuni
    * @since    2015-10-22
    *
    * @access   public
    * @return   void
    */
    public function findTm($role)
    {
        return $this->import('tm')->find($role);
    }
    
    
    /**
     * 得到分类描述
     * @param $class
     * @return mixed
     */
    public function getClassInfo($class){
        $r['eq']['id'] = $class;
        $r['col'] = array('label','title','name');
        $res = $this->import('class')->find($r);
        if($res){
            return $res;
        }
        return '';
    }
    
    /**
    * 商标基础信息
    *
    * @author   Xuni
    * @since    2015-10-22
    *
    * @access   public
    * @return   void
    */
    public function getInfo($tid, $field = '')
    {
        if ( intval($tid) <= 0 ) return array();

        $r['eq']    = array('auto'=>$tid);
        if ( !empty($field) &&  is_array($field) ){
            $r['col'] = $field;
        }

        return $this->findTm($r);
    }

    /**
    * 获取商标图片地址
    *
    * @author   Xuni
    * @since    2015-10-22
    *
    * @access   public
    * @return   void
    */
    public function getImg($number)
    {
        $default = '/Static/images/img1.png';
        if ( intval($number) <= 0 ) return $default;
        $r['eq']    = array('trademark_id'=>$number);
        $img        = $this->import('img')->find($r);
        return empty($img) ? $default : $img['url'];
    }

 /**
     * 获取商标分类与群组相关标题
     *
     * 获取商标分类与群组相关标题
     * 
     * @author  Xuni
     * @since   2016-03-08
     *
     * @return  array
     */
    public function getClassGroup($class=0, $group=1)
    {
        if ( $class == 0 && $group != 1 ){
            $r['eq'] = array('parent'=>0);
        }elseif ( $class != 0 && $group == 1 ){
            //$r['eq'] = array('parent'=>$class);
            $r['raw'] = " (`parent` = '$class' OR `number` = '$class') ";
        }elseif ( $class != 0 ){
            $r['eq'] = array('number'=>$class);
        }
        //$r['order'] = array('parent'=>'asc','number'=>'asc');
        $r['limit'] = 1000;

        $_class = $_group = array();
        $res    = $this->import('class')->find($r);
        if ( empty($res) ) return array();

        foreach ($res as $k => $v) {
            if ( $v['parent'] == '0' ){
                $_class[$v['number']] = empty($v['title']) ? $v['name'] : $v['title'];
            }elseif ( $v['parent'] != 0 ){
                $_group[$v['parent']][$v['number']] = empty($v['title']) ? $v['name'] : $v['title'];
            }
        }
        ksort($_class);
        return array($_class, $_group);
    }

    //获取查询的TITLE
    public function getSeo($all)
    {
        foreach ($all as $k => $value) {
                if (empty($value) && count($all)==1) return;
                $_arr = array_filter( explode(',', $value) );
                switch ($k) {
                    case 'name':
                        $S      = C('SBSEARCH');
                        $kt     = intval($all['kt']) <= 0 ? 1 : intval($all['kt']);
                        if(!empty($value)) $kname   = $S[$kt].':'.$value.' ';
                         $this->createKeywordCount($value,1,$k,$value);
                        break;
                    case 'class':
                        list($cArr,) = $this->getClassGroup(0, 0);
                        foreach ($_arr as $v) {
                            if(count($all)>=2){
                                $c_str .= $cArr[$v].' '.$v.'类 ';
                                $c_name_str .= $cArr[$v].' ';
                                $c_id_str = '第'.$v.'类'.$cArr[$v].' ';
                                $c_name = $cArr[$v];
                                $c_id = $v;
                            }else{
                                $c_name = $cArr[$v];
                                $c_id = $v;
                            }
                             $this->createKeywordCount("$v-".$cArr[$v],4,$k,$value);
                        }
                        break;
                    case 'type':
                        $T = C('TYPES');/*组合类型*/
                        foreach ($_arr as $v) {
                            $t_str .= $T[$v].' ';
                            $this->createKeywordCount("$v-".$T[$v],6,$k,$value);
                        }
                        break;
                    case 'length':
                        $N      = C('SBNUMBER');/*商标字数*/
                        $_hasN  = false;
                        foreach ($_arr as $v) {
                            if ( $v == '1' || $v == '2' ){
                                $_hasN = true;
                            }else{
                                $sn_str .= $N[$v].' ';
                                $this->createKeywordCount($N[$v],7,$k,$value);
                            }
                        }
                        if ( $_hasN ){
                             $sn_str = $N['1,2'].' '.$sn_str;
                             $this->createKeywordCount($N['1,2'],7,$k,$value);
                        }
                        break;
                }
            }
            if(count($all)<=3 && !empty($c_name) && empty($g_name) && count($_arr)==1){
                $title = '第'.$c_id.'类'.$c_name.' 商标转让交易买卖价格|一只蝉商标转让平台网';
                $description = '第'.$c_id.'类商标转让价格要多少钱？了解'.$c_name.'商标转让价格到一只蝉'.$c_name.'商标交易平台第一时间获取'.$c_id.'类商标交易价格动态变化；一只蝉商标转让平台-独家签订交易损失赔付保障协议商标交易平台';
            }else{
                $title = $kname.$p_str.$g_str.$c_str.$sn_str.$t_str.'商标转让交易买卖价格|一只蝉商标转让平台网';
                $description =$kname.$p_str.$g_name_str.'商标转让价格要多少钱？了解'.$c_name_str.$sn_str.$t_str.'商标转让价格到一只蝉'.$c_id_str.'商标交易平台第一时间获取'.$g_name_str.'商标交易价格动态变化；一只蝉商标转让平台-独家签订交易损失赔付保障协议商标买卖平台';
            }
            return array("title"=>$title,"description"=>$description);
    }
    
    /**
     * 写入搜索数据
     * 
     * @author  Far
     * @since   2016-05-20
     * @access  public
     * @param   string      $kw        搜索关键词
     * @param   int         $type      搜索类型
     * @param   int         $type      搜索类型关键词KEY
     * @param   int         $type      搜索类型关键词的值（简写）
     */
    public function createKeywordCount($kw, $type, $ktype,$val)
    {
        if ( empty($kw) || empty($type)) return '0';
        $ip =  getClientIp();
        //判断上一次搜索是否有相同的
        $list = $this->com('redisHtml')->get('kw_'.$ip);
        if($list[$ktype]==$val) return '0';
        
            
        $data = array(
           'keyword'   => $kw,
           'type'      => $type,
           'sid'       => $_COOKIE['sat5_sid'],
           'ip'        => $ip,
           'date'      => time(),
           );
           return $this->import('kwcount')->create($data);
    }
}
?>