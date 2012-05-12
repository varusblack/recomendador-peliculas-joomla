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
		$identificadores = array();
		$user =& JFactory::getUser();
		
		$peliculasSinVotar = $modeloVotaciones->obtenerPeliculasAleatoriasNoVotadasPorUsuario($user->id);
		foreach ($peliculasSinVotar as $peli) {
			$idPelicula = $peli["id"];
			$identificadores[] = $idPelicula;
			$categs = $modeloCategorias->obtenerCategoriasDePeliculas($idPelicula);
			$categoriasPeliculas[$idPelicula] = $categs;
		}
		
		$vista = $this->getView("films", "html");
		$vista->assignRef("categoriasPeliculas",$categoriasPeliculas);
		$vista->assignRef("peliculas",$peliculasSinVotar);
		$vista->assignRef("identificadores",$identificadores);
		$vista->votar();
	}
	
	function cambiarVoto(){
		$idPelicula = JRequest::getVar('id');
		$puntuacion = JRequest::getVar('puntuacion');
		$user =& JFactory::getUser();
		$idUsuario = $user->id;
		
		$modeloVotaciones = $this->getModel('votacionesPelicula');
		
		$modeloVotaciones->actualizarVoto ($idUsuario, $idPelicula, $puntuacion);
		
		$this->verDetalles();
		
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
		
		$pelicula = $modeloVotacionesPelicula->obtenerUnicaPeliculaVotadaPorUsuario ($user->id,$idPelicula);
		$actores = $modeloActoresPelicula->obtenerActoresDePelicula($pelicula["id"]);
		$categoriasPelicula = $modeloPeliculasCategorias->obtenerCategoriasDePeliculas($pelicula["id"]);
		
		$vista = $this->getView('films','html');
		$vista->assignRef("pelicula",$pelicula);
		$vista->assignRef("actores",$actores);
		$vista->assignRef("categorias",$categoriasPelicula);
		
		$vista->verDetalles();
	}
	
	function votarMasivo(){
		$user =& JFactory::getUser();
		$idUsuario = $user->id;
		$identificadores = JRequest::getVar("identificadores");
		$identificadores = unserialize(base64_decode($identificadores));
		$puntuaciones = array();
		
		$modeloVotaciones = $this->getModel('votacionesPelicula');
		
		foreach($identificadores as $identificador){
			$puntuacion = JRequest::getVar('puntuacion'.$identificador);
			$puntuaciones[$identificador] = $puntuacion;
		}
		
		foreach ($puntuaciones as $identificador => $puntuacion) {
			if(strcmp($puntuacion, "no") != 0){
				$modeloVotaciones->votarPelicula ($idUsuario, $identificador, $puntuacion);
			}
		}
		
		$this->votar();
	}
	
	function busquedaRapida(){
		$titulo = JRequest::getVar("tituloBuscado");
		
	}
}

?>
	