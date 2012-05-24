<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class PeliculasController extends JController {

    function __construct($config = array()) {
        parent::__construct($config);
        $this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR . DS . 'models');
    }

    function votar() {
        $modeloVotaciones = $this->getModel('votacionesPelicula');
        $modeloCategorias = $this->getModel('peliculasCategorias');

        $categoriasPeliculas = array();
        $identificadores = array();
        $user = & JFactory::getUser();

        $peliculasSinVotar = $modeloVotaciones->obtenerPeliculasAleatoriasNoVotadasPorUsuario($user->id);
        foreach ($peliculasSinVotar as $peli) {
            $idPelicula = $peli["id"];
            $identificadores[] = $idPelicula;
            $categs = $modeloCategorias->obtenerCategoriasDePeliculas($idPelicula);
            $categoriasPeliculas[$idPelicula] = $categs;
        }

        $vista = $this->getView("votarPeliculas", "html");
        $vista->assignRef("categoriasPeliculas", $categoriasPeliculas);
        $vista->assignRef("peliculas", $peliculasSinVotar);
        $vista->assignRef("identificadores", $identificadores);
        $vista->display();
    }

    function cambiarVoto() {
        $idPelicula = JRequest::getVar('id');
        $puntuacion = JRequest::getVar('puntuacion');
        $user = & JFactory::getUser();
        $idUsuario = $user->id;

        $modeloVotaciones = $this->getModel('votacionesPelicula');

        $modeloVotaciones->actualizarVoto($idUsuario, $idPelicula, $puntuacion);

        $this->verDetalles();
    }

    function vervotadas() {
        $modeloVotaciones = $this->getModel('votacionesPelicula');
        $modeloCategorias = $this->getModel('peliculasCategorias');

        $categoriasPeliculas = array();
        $user = & JFactory::getUser();

        $peliculasVotadas = $modeloVotaciones->obtenerPeliculasVotadasPorUsuario($user->id);
        foreach ($peliculasVotadas as $peli) {
            $idPelicula = $peli["id"];
            $categs = $modeloCategorias->obtenerCategoriasDePeliculas($idPelicula);
            $categoriasPeliculas[$idPelicula] = $categs;
        }

        $vista = $this->getView("films", "html");
        $vista->assignRef("categoriasPeliculas", $categoriasPeliculas);
        $vista->assignRef("peliculas", $peliculasVotadas);
        $vista->vervotadas();
    }

    function verDetalles() {
        $user = & JFactory::getUser();
        $idPelicula = JRequest::getVar('id');
		$modeloPelicula = $this->getModel('films');
        $modeloVotacionesPelicula = $this->getModel('votacionesPelicula');
        $modeloActoresPelicula = $this->getModel('actoresPelicula');
        $modeloPeliculasCategorias = $this->getModel('peliculasCategorias');

		$pelicula = $modeloPelicula->obtenerPeliculaPorId($idPelicula);
        $otrosDatosPelicula = $modeloVotacionesPelicula->obtenerUnicaPeliculaVotadaPorUsuario($user->id, $idPelicula);
        $actores = $modeloActoresPelicula->obtenerActoresDePelicula($pelicula["id"]);
        $categoriasPelicula = $modeloPeliculasCategorias->obtenerCategoriasDePeliculas($pelicula["id"]);

        $vista = $this->getView('films', 'html');
        
        if(count($otrosDatosPelicula) > 0){
        	$vista->assignRef("otrosdatos",$otrosDatosPelicula);
        }
		$vista->assignRef("pelicula", $pelicula);
        $vista->assignRef("actores", $actores);
        $vista->assignRef("categorias", $categoriasPelicula);

        $vista->verDetalles();
    }

    function votarMasivo() {
        $user = & JFactory::getUser();
        $idUsuario = $user->id;
        $identificadores = JRequest::getVar("identificadores");
        $identificadores = unserialize(base64_decode($identificadores));
        $puntuaciones = array();

        $modeloVotaciones = $this->getModel('votacionesPelicula');

        foreach ($identificadores as $identificador) {
            $puntuacion = JRequest::getVar('puntuacion' . $identificador);
            $puntuaciones[$identificador] = $puntuacion;
        }

        foreach ($puntuaciones as $identificador => $puntuacion) {
            if (strcmp($puntuacion, "no") != 0) {
                $modeloVotaciones->votarPelicula($idUsuario, $identificador, $puntuacion);
            }
        }

        $this->votar();
    }
	

    function busquedaRapida() {
        $titulo = JRequest::getVar("tituloBuscado");
		
		$campos = array();
		
		if(strlen($titulo) > 1){
			$campos["tituloEspanol"] = $titulo;
		}
		
		$this->ejecutarBusqueda($campos);
    }
	
	function prepararBusquedaAvanzada() {
		$modeloCategoria = $this->getModel("categorias");
		$categorias = $modeloCategoria->obtenerTodasLasCategorias();
		
		$vista = $this->getView('films','html');
		$vista->assignRef("categorias",$categorias);
		$vista->busquedaYResultados();
	}

	function busquedaAvanzada() {
		$titulo = JRequest::getVar("titulo");
		$tituloEspanol = JRequest::getVar("tituloEspanol");
		$anno = JRequest::getVar("anno");
		$nombreDirector = JRequest::getVar("nombreDirector");
		$idCategoria = JRequest::getVar("idCategoria");
		$nombreActor1 = JRequest::getVar("nombreActor1");
		$nombreActor2 = JRequest::getVar("nombreActor2");
		$nombreActor3 = JRequest::getVar("nombreActor3");
		
		$campos = array();
		
		if(strlen($titulo) > 1){
			$campos["titulo"] = $titulo;
		}
		
		if(strlen($tituloEspanol) > 1){
			$campos["tituloEspanol"] = $tituloEspanol;
		}
		
		if(strlen($anno) > 1){
			$campos["anno"] = $anno;
		}
		
		if(strlen($nombreDirector) > 1){
			$campos["nombreDirector"] = $nombreDirector;
		}
		
		if(strlen($idCategoria) != 0){
			$campos["idCategoria"] = $idCategoria;
		}
		
		if(strlen($nombreActor1) > 1){
			$campos["nombreActor1"] = $nombreActor1;
		}
		
		if(strlen($nombreActor2) > 1){
			$campos["nombreActor2"] = $nombreActor2;
		}
		
		if(strlen($nombreActor3) > 1){
			$campos["nombreActor3"] = $nombreActor3;
		}
		
		$this->ejecutarBusqueda($campos);
	}

	function ejecutarBusqueda($campos){
		$peliculas = array();
		
		$modeloCategoria = $this->getModel("categorias");
		
		$categorias = $modeloCategoria->obtenerTodasLasCategorias();
		
		$vista = $this->getView('films','html');
		$vista->assignRef("categorias",$categorias);
		
		if(count($campos) > 0){
			$modeloFilms = $this->getModel("films");
			$identificadoresPeliculas = $modeloFilms->obtenerPeliculasPorCampos ($campos);
			
			if(count($identificadoresPeliculas) > 0){
				foreach($identificadoresPeliculas as $ids){
					foreach($ids as $id){
						$pelicula = $modeloFilms->obtenerPeliculaPorId($id);
						$peliculas[] = $pelicula;
					}
				}
				
			}
		}
		$vista->assignRef("peliculas",$peliculas);
		$vista->busquedaYResultados();
	}

}


?>