<?php
    defined('_JEXEC') or die("acceso denegado");
	
	require_once(dirname(__FILE__).DS.'helper.php');
	
	$filmCount = $params->get('filmcount');
	
	$items = ModJDatabaseHelper::getItems($filmCount);
	
	require(JModuleHelper::getLayoutPath('mod_jdatabase'));
	

?>