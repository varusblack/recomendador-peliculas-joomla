<?php

defined('_JEXEC') or die('Restricted access');

$controller = JRequest::getVar('controller');

if ($controller == ''){
	require_once (JPATH_COMPONENT_ADMINISTRATOR . DS . 'controllers' . DS . 'default.php');
	$component_name = 'Peliculas';
	$classname = $component_name . 'ControllerDefault';
	$controller = new $classname();
	$task = 'mostrar';
}else{
	require_once (JPATH_COMPONENT_ADMINISTRATOR . DS . 'controllers' . DS . $controller . '.php');
	$component_name = 'Peliculas';
	$classname = $component_name . 'Controller' . $controller;
	$controller = new $classname();
	$task = JRequest::getWord('task');
}

$controller->execute($task);

$controller->redirect();

?>