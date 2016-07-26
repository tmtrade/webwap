<?
/**
 * 定义应用所需常量
 */
$define = array(
        
    'COOKIE_PREFIX'     => 'wap_',//网站cookie前缀
    'PUBLIC_USER'       => 'ChOfNuSeR',//公用用户登录信息标识
    'PUBLIC_USER_TIME'  => 1800,//用户登录信息有效时间
    'PUBLIC_RECORD'     => 'record',//用户浏览历史信息标识

    'MSG_TEMPLATE' => array(
        'msg' => "您正在一只蝉上咨询商标价格，请保持手机畅通，客服即将为您服务.",
        'id' => "1927",
    ),
    
    //1-45分类
    'CLASSES' => array(
		'1'   => '化工原料',
		'2'   => '油漆涂料',
		'3'   => '化妆清洁',
		'4'   => '工业油脂',
		'5'   => '药品制剂',
		'6'   => '五金器具',
		'7'   => '机械机器',
		'8'   => '手工用具',
		'9'   => '电子电器',
		'10'  => '医疗器械',
		'11'  => '家用电器',
		'12'  => '车船配件',
		'13'  => '火器烟花',
		'14'  => '珠宝饰品',
		'15'  => '乐器乐辅',
		'16'  => '文具办公',
		'17'  => '橡塑制品',
		'18'  => '皮具制品',
		'19'  => '建筑材料',
		'20'  => '家具工艺',
		'21'  => '厨具日用',
		'22'  => '缆绳帐篷',
		'23'  => '线纱丝纺',
		'24'  => '家用纺品',
		'25'  => '服装鞋帽',
		'26'  => '缝纫用品',
		'27'  => '地毯席垫',
		'28'  => '运动器械',
		'29'  => '食品鱼肉',
		'30'  => '食品佐料',
		'31'  => '生鲜农产',
		'32'  => '啤酒饮料',
		'33'  => '酒精饮料',
		'34'  => '烟草制品',
		'35'  => '广告商业',
		'36'  => '金融经纪',
		'37'  => '修理安装',
		'38'  => '通讯服务',
		'39'  => '运输旅行',
		'40'  => '加工服务',
		'41'  => '教育娱乐',
		'42'  => '科技研究',
		'43'  => '餐饮住宿',
		'44'  => '医疗美容',
		'45'  => '法律安全',
    ),


	
	//商标类型
    'TYPES' => array(
        '1'  => '纯中文',
        '2'  => '纯英文',
        '3'  => '纯图形',
        '4'  => '中+英',
        '5'  => '中+图',
        '6'  => '英+图',
        '7'  => '中+英+图',
        '8'  => '纯数字',
    ),
    //商标字数
    'SBNUMBER' => array(
        '1,2'  => '1-2个字',
        '3'  => '3个字',
        '4'  => '4个字',
        '5'  => '5个字',
        '6'  => '5个字及以上',
    ),

    /*平台入驻*/
    'PLATFORM_IN' => array(
     //   '99'  => '自营',
        '1'  => '京东',
        '2'  => '天猫',
        '7'  => '大型超市',
        '3'  => '亚马逊',
        '4'  => '1号店',  
        '5'  => '美丽说',
        '6'  => '聚美优品',
    ),

	'VIEW_HISTORY'  =>'view_history',
	'SEARCH_HISTORY'  =>'_search_history_',
	'FEEDBACKER'	=> 'services@chofn.com',//一只蝉反馈收件邮箱
	'SecondStatus' => array(
		1 => '申请中',
		2 => '已注册',
		3 => '商标已无效',
		4 => '驳回中',
		5 => '驳回复审中',
		6 => '部分驳回',
		7 => '公告中',
		8 => '异议中',
		9 => '异议复审中',
		10 => '需续展',
		11 => '续展中',
		12 => '开具优先权证明中',
		13 => '开具注册证明中',
		14 => '撤销中',
		15 => '撤销复审中',
		16 => '撤回撤销中',
		17 => '变更中',
		18 => '变更代理人中',
		19 => '补证中',
		20 => '补变转续证中',
		21 => '转让中',
		22 => '更正中',
		23 => '许可备案中',
		24 => '许可备案变更中',
		25 => '删减商品中',
		26 => '冻结中',
		27 => '注销中',
		28 => '无效宣告中',
	),
	//专利大类别
	'PATENT_TYPE' => array (
		1     => '发明',
		2     => '实用新型',
		3     => '外观设计',
	),
	//专利分类
	'PATENT_ClASS_ONE' => array (
		'a'     => '人类生活必需',
		'b'     => '作业-运输',
		'c'     => '化学-冶金',
		'd'     => '纺织-造纸',
		'e'     => '固定建筑物',
		'f'     => '机械工程-照明-加热-武器-爆破',
		'g'     => '物理',
		'h'     => '电学',
	),
	//专利分类
	'PATENT_ClASS_TWO' => array (
		'01'     => '食品',
		'02'     => '服装和服饰用品',
		'03'     => '其他类未列入的旅行用品、箱子、阳伞和个人用品',
		'04'     => '刷子类',
		'05'     => '纺织品、人造或天然材料片材',
		'06'     => '家具',
		'07'     => '其他类未列入的家用物品',
		'08'     => '工具和金属器具',
		'09'     => '用于商品运输或装卸的包装和容器',
		'10'     => '钟、表和其他计量仪器、检测和信号仪器',
		'11'     => '装饰品',
		'12'     => '运输或提升工具',
		'13'     => '发电、配电和输电的设备',
		'14'     => '录音、通讯或信息再现设备',
		'15'     => '其他类未列入的机械',
		'16'     => '照相、电影摄影和光学仪器',
		'17'     => '乐器',
		'18'     => '印刷和办公机械',
		'19'     => '文具用品、办公设备、美术用品及教学材料',
		'20'     => '销售和广告设备、标志',
		'21'     => '游戏器具、玩具、帐篷和体育用品',
		'22'     => '武器、烟火用具、用于狩猎、捕鱼及捕杀有害动物的器具',
		'23'     => '液体分配设备，卫生、供暖、通风和空调设备，固体燃料',
		'24'     => '医疗和实验室设备',
		'25'     => '建筑构件和施工元件',
		'26'     => '照明设备',
		'27'     => '烟草和吸烟用具',
		'28'     => '药品、化妆品、梳妆用品和器具',
		'29'     => '防火灾、防事故救援装置和设备',
		'30'     => '动物的管理与驯养设备',
		'31'     => '其他类未列入的食品或饮料制作机械和设备',
		'99'     => '其他杂项',
	),
);


return $define;

?>