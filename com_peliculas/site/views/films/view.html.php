<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class PeliculasViewFilms extends JView {
	
	function display($tpl=null) {
		parent::display();
	}
	
	function votar(){
		parent::display('votar');
	}
	
	function vervotadas(){
		parent::display('vervotadas');
	}
	
	function verDetalles(){
		parent::display('detalles');
	}
	
	function busquedaYResultados(){
		parent::display('busquedayresultados');
	}

}

?>