<?
$prefix		= 'tm_';
$dbId		= 'trademark';
$configFile	= array( ConfigDir.'/Db/trademark.master.config.php' );

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

$tbl['group'] = array(
	'name'		=> $prefix.'tmclass_group',
	'dbId'		=> $dbId, 
	'configFile'=> $configFile,
);

?>