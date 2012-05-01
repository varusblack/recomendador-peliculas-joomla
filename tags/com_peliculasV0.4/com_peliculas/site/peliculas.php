<?php
	defined('_JEXEC') or die('Restricted access');
	
	$controller='';
	
	if ($controller = JRequest::getVar('controller')) {
		require_once (JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
	} else
		require_once( JPATH_COMPONENT.DS.'controller.php' );
	
	$component_name='Biblioteca';
	$classname = $component_name.'Controller'.$controller;
	$controller = new $classname();
	
	$controller->execute(JRequest::getWord('task'));

	$controller->redirect();

?>