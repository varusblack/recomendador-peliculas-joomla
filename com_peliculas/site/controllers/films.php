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
		$modeloCategorias = $this->getModel('peliculasCategorias');
		
		$categoriasPeliculas = array();
		$user =& JFactory::getUser();
		
		$peliculasSinVotar = $modeloVotaciones->obtenerPeliculasAleatoriasNoVotadasPorUsuario($user->id);
		foreach ($peliculasSinVotar as $peli) {
			$idPelicula = $peli["id"];
			$categs = $modeloCategorias->obtenerCategoriasDePeliculas($idPelicula);
			$categoriasPeliculas[$idPelicula] = $categs;
		}
		
		$vista = $this->getView("films", "html");
		$vista->assignRef("categoriasPeliculas",$categoriasPeliculas);
		$vista->assignRef("peliculas",$peliculasSinVotar);
		$vista->votar();
	}
	
	function grabarVotos(){
		$user =& JFactory::getUser();
		$idUser = $user->id;
		
	}
	
	function vervotadas(){
		$modeloVotaciones = $this->getModel('votacionesPelicula');
		$modeloCategorias = $this->getModel('peliculasCategorias');
		
		$categoriasPeliculas = array();
		$user =& JFactory::getUser();
		
		$peliculasVotadas = $modeloVotaciones->obtenerPeliculasVotadasPorUsuario($user->id);
		foreach ($peliculasVotadas as $peli) {
			$idPelicula = $peli["id"];
			$categs = $modeloCategorias->obtenerCategoriasDePeliculas($idPelicula);
			$categoriasPeliculas[$idPelicula] = $categs;
		}
		
		$vista = $this->getView("films", "html");
		$vista->assignRef("categoriasPeliculas",$categoriasPeliculas);
		$vista->assignRef("peliculas",$peliculasVotadas);
		$vista->vervotadas();
	}
	
	function verDetalles(){
		$user =& JFactory::getUser();
		$idPelicula = JRequest::getVar('id');
		$modeloVotacionesPelicula = $this->getModel('votacionesPelicula');
		$modeloActoresPelicula = $this->getModel('actoresPelicula');
		$modeloPeliculasCategorias = $this->getModel('peliculasCategorias');
		
		$peliculaVotada = $modeloVotacionesPelicula->obtenerPeliculasVotadasPorUsuario($user->id);
		$pelicula = $peliculaVotada[0];
		$actores = $modeloActoresPelicula->obtenerActoresDePelicula($pelicula["id"]);
		$categoriasPelicula = $modeloPeliculasCategorias->obtenerCategoriasDePeliculas($pelicula["id"]);
		
		$vista = $this->getView('films','html');
		$vista->assignRef("pelicula",$pelicula);
		$vista->assignRef("actores",$actores);
		$vista->assignRef("categorias",$categoriasPelicula);
		
		$vista->verDetalles();
	}
}

?>
	