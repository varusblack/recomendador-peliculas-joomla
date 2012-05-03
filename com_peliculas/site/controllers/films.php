<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class PeliculasControllerFilms extends JController {

	function __construct($config = array()) {
        parent::__construct($config);
        $this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR . DS . 'models');
    }
	
	function votar(){
		$modeloVotaciones = $this->getModel('votacionesPelicula');
		$user =& JFactory::getUser();
		$peliculasSinVotar = $modeloVotaciones->obtenerPeliculasAleatoriasNoVotadasPorUsuario($user->id);
		$vista = $this->getView("films", "html");
		$vista->assignRef("peliculas",$peliculasSinVotar);
		$vista->votar();
	}
	
	function vervotadas(){
		$modeloVotaciones = $this->getModel('votacionesPelicula');
		$user =& JFactory::getUser();
		$peliculasVotadas = $modeloVotaciones->obtenerPeliculasVotadasPorUsuario($user->id);
		$vista = $this->getView("films", "html");
		$vista->assignRef("peliculas",$peliculasVotadas);
		$vista->vervotadas();
	}
	
	
}

?>
	