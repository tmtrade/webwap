<?
$prefix		= 't_';
$dbId		= 'trade_new';
$prefixs	= 's_'; //出售者平台
$prefix_my      = "my_";
$configFile	= array( ConfigDir.'/Db/trade.master.config.php' );

$tbl['sale'] = array(
	'name'		=> $prefix.'sale',
	'dbId'		=> $dbId, 
	'configFile'=> $configFile,
);
$tbl['classGroup'] = array(
	'name'		=> $prefix.'class_group',
	'dbId'		=> $dbId,
	'configFile'=> $configFile,
);
$tbl['saleContact'] = array(
	'name'		=> $prefix.'sale_contact',
	'dbId'		=> $dbId,
	'configFile'=> $configFile,
);

$tbl['saleTminfo'] = array(
	'name'		=> $prefix.'sale_tminfo',
	'dbId'		=> $dbId, 
	'configFile'=> $configFile,
);

$tbl['seo'] = array(
	'name'		=> $prefix.'seo',
	'dbId'		=> $dbId, 
	'configFile'=> $configFile,
);

$tbl['patent'] = array(
	'name'		=> $prefix.'patent',
	'dbId'		=> $dbId,
	'configFile'=> $configFile,
);

$tbl['patentContact'] = array(
	'name'		=> $prefix.'patent_contact',
	'dbId'		=> $dbId,
	'configFile'=> $configFile,
);

$tbl['patentInfo'] = array(
	'name'		=> $prefix.'patent_info',
	'dbId'		=> $dbId,
	'configFile'=> $configFile,
);

$tbl['patentList'] = array(
	'name'		=> $prefix.'patent_list',
	'dbId'		=> $dbId,
	'configFile'=> $configFile,
);

$tbl['blacklist'] = array(
	'name'		=> $prefix.'blacklist',
	'dbId'		=> $dbId,
	'configFile'=> $configFile,
);

$tbl['phone'] = array(
	'name'		=> $prefix.'phone',
	'dbId'		=> $dbId,
	'configFile'=> $configFile,
);
$tbl['phoneEnquiry'] = array(
	'name'		=> $prefix.'phone_enquiry',
	'dbId'		=> $dbId,
	'configFile'=> $configFile,
);
$tbl['user'] = array(
	'name'		=> $prefix_my.'user',
	'dbId'		=> $dbId, 
	'configFile'=> $configFile,
);
?>