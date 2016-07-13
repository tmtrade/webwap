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
        'valid'     => "验证码：%s，有效期为10分钟，请尽快使用。",
        'register'  => "%s（登录密码），系统已为您开通手机账户，登陆可查看求购进展，工作人员不会向你索要，请勿向任何人泄露。",
        'newValid'  => "%s（动态登录密码），仅本次有效，请在10分钟内使用。工作人员不会向你索要，请勿向任何人泄露。",
        'validBind' => "%s（手机绑定校验码），仅本次有效请在10分钟内使用。工作人员不会向你索要，请勿向任何人泄露。如非本人操作，请忽略。",
        ),

	'VIEW_HISTORY'  =>'view_history',
    'SEARCH_HISTORY'  =>'_search_history_',
	'FEEDBACKER'	=> 'services@chofn.com',//一只蝉反馈收件邮箱

);


return $define;

?>