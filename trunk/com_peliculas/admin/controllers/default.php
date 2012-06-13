<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class PeliculasControllerDefault extends JController{
	
	function __construct($config = array()) {
        parent::__construct($config);
        $this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR . DS . 'films');
    }
	
	function mostrar(){
		$vista = $this->getView('default','html');
		$vista->display();
	}
}


?>