<?php

defined('_JEXEC') or die('Restricted access');

$controller = '';



if ($controller = JRequest::getVar('controller')) {
    require_once (JPATH_COMPONENT_ADMINISTRATOR . DS . 'controllers' . DS . $controller . '.php');
} else{
    require_once( JPATH_COMPONENT_ADMINISTRATOR . DS . 'controller.php' );
}
$component_name = 'Peliculas';
$classname = $component_name . 'Controller' . $controller;
$controller = new $classname();

$controller->execute(JRequest::getWord('task'));

$controller->redirect();
?>