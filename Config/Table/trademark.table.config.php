<?
$prefix		= 'tm_';
$dbId		= 'trademark';
$configFile	= array( ConfigDir.'/Db/trademark.master.config.php' );

$tbl['proposer'] = array(
	'name'		=> $prefix.'proposer',
	'dbId'		=> $dbId, 
	'configFile'=> $configFile,
);

$tbl['proposerNew'] = array(
	'name'		=> $prefix.'proposer_new',
	'dbId'		=> $dbId, 
	'configFile'=> $configFile,
);

$tbl['secondStatus'] = array(
	'name'		=> $prefix.'second_status',
	'dbId'		=> $dbId, 
	'configFile'=> $configFile,
);

$tbl['trademark'] = array(
	'name'		=> $prefix.'trademark',
	'dbId'		=> $dbId, 
	'configFile'=> $configFile,
);

$tbl['imgurl'] = array(
	'name'		=> $prefix.'imgurl',
	'dbId'		=> $dbId, 
	'configFile'=> $configFile,
);
$tbl['agent'] = array(
	'name'		=> $prefix.'agent',
	'dbId'		=> $dbId, 
	'configFile'=> $configFile,
);

$tbl['group'] = array(
	'name'		=> $prefix.'tmclass_group',
	'dbId'		=> $dbId, 
	'configFile'=> $configFile,
);

$tbl['statusNew'] = array(
	'name'		=> $prefix.'status_new',
	'dbId'		=> $dbId, 
	'configFile'=> $configFile,
);

$tbl['notice'] = array(
	'name'		=> $prefix.'notice',
	'dbId'		=> $dbId, 
	'configFile'=> $configFile,
);

$tbl['noticeType'] = array(
	'name'		=> $prefix.'notice_type',
	'dbId'		=> $dbId, 
	'configFile'=> $configFile,
);
?>