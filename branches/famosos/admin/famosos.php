<?php
    defined('_JEXEC') or die('Restricted access');
    
    require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'controller.php');
    
    $component_name="Famosos";
    $classname=$component_name.'Controller';
    $controlador=new $classname();
    
    $controlador->execute(JRequest::getWord('task'));
    $controlador->redirect();
?>