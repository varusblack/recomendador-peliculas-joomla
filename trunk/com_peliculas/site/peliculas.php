<?php
	defined('_JEXEC') or die('Restricted access');
	
	require_once(JPATH_COMPONENT.DS.'controller.php');
	
	$component_name='Peliculas';
	$classname = $component_name.'Controller'.$controller;
	$controller = new $classname();
	
	$controller->execute(JRequest::getWord('task'));

	$controller->redirect();

?>