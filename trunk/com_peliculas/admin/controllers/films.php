<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class PeliculasControllerFilms extends JController {

    function __construct($config = array()) {
        parent::__construct($config);
        $this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR . DS . 'films');
    }

    function display() {
        $modelo = $this->getModel("films");
        $films = $modelo->obtenerPeliculasLimites();

        $vista = $this->getView("films", "html");
        $pagination = $modelo->getPagination();
        $vista->assignRef("pagination", $pagination);
        $vista->assignRef("films", $films);
        $vista->display();
    }

    function edit() {
        $cid = JRequest::getVar("cid", 0, "", "array");
        $modelo = $this->getModel("films");
        $film = $modelo->obtenerPeliculaPorId($cid[0]);
		$director = $modelo->obtenerDirector($film["id"]);
		
		$modeloActoresPelicula = $this->getModel("actoresPelicula");
		$actores = $modeloActoresPelicula->obtenerActoresDePelicula($film["id"]);
		
		$modeloPeliculasCategorias = $this->getModel("peliculasCategorias");
		$categorias = $modeloPeliculasCategorias->obtenerCategoriasDePeliculas($film["id"]);

        $vista = $this->getView("films", "html");
        $vista->assignRef("film", $film);
		$vista->assignRef("director",$director);
		$vista->assignRef("actores",$actores);
		$vista->assignRef("categorias",$categorias);
        $vista->edit();
    }

    function save() {
        $id = JRequest::getVar("id");
        $titulo = JRequest::getVar("titulo");
        $anno = JRequest::getVar("anno");
        $videoRelease = JRequest::getVar("videoRelease");
        $tituloEsp = JRequest::getVar("tituloEsp");

        $modelo = $this->getModel("films");
        $modeloActoresPelicula = $this->getModel("actoresPelicula");
        $modeloPeliculasCategorias = $this->getModel("peliculasCategorias");
		
		$enlace;

        if ($id != "") {
            $correcto = $modelo->actualizarPelicula($id, $titulo, $anno, $videoRelease, $tituloEsp);
			$enlace = 'index.php?option=com_peliculas&controller=films&task=edit&cid[]='.$id;
			
            if ($correcto) {
                $aviso = "La actualización se ha realizado con exito ";
            } else {
                $aviso = "Error en la actualizacion ";
            }
        } else {
            $correcto = $modelo->insertarPelicula($titulo, $anno, $videoRelease, $tituloEsp);
			$enlace = 'index.php?option=com_peliculas&controller=films';
            if ($correcto) {
                $aviso = "La insercion se ha realizado con exito";
            } else {
                $aviso = "Error en la insercion";
            }
        }
        $this->setRedirect($enlace, $aviso);
    }

    function add() {
        $vista = $this->getView('films', 'html');
        $vista->add();
    }
	
    function remove() {
        $cid = JRequest::getVar('cid', 0, '', 'array');
        $modelo = $this->getModel('films');
        $films = array();
        foreach ($cid as $idFilm) {
            $film = $modelo->obtenerPeliculaPorId($idFilm);
            $films[] = $film;
        }

        $vista = $this->getView('Films', 'html');
        $vista->assignRef('films', $films);
        $vista->remove();
    }

    function processRemove() {
        $elementsToDelete = JRequest::getVar('elementsToDelete');
        $elementsToDelete = unserialize(base64_decode($elementsToDelete));
        
        $modeloFilms = $this->getModel('films');
        $modeloPeliculasCategorias=$this->getModel('peliculasCategorias');
        $modeloActoresPelicula=$this->getModel('actoresPelicula');
        
        foreach ($elementsToDelete as $element) {
            $modeloFilms->borrarPelicula($element["id"]);
            $modeloPeliculasCategorias->deleteByPelicula($element["id"]);
            $modeloActoresPelicula->borrarPorPelicula($element["id"]);
        }
        $correcto=true;
        if ($correcto) {
            $aviso = "Se borraron los elementos seleccionados";
        } else {
            $aviso = "No se borraron los elementos seleccionados";
        }

        $enlace = 'index.php?option=com_peliculas&controller=films';
        $this->setRedirect($enlace, $aviso);
    }
	
	function insertarDirector() {
		$id = JRequest::getVar("id");
		$modelo = $this->getModel("films");
        $film = $modelo->obtenerPeliculaPorId($id);
		
		$modeloFamosos = $this->getModel("famosos");
		$famosos = $modeloFamosos->obtenerTodosLosFamosos();	
			
		$vista = $this->getView('films', 'html');
		$vista->assignRef("film",$film);
		$vista->assignRef("famosos",$famosos);
		$vista->insertarDirector();
		
	}
	
	function grabarDirector(){
		$idPelicula = JRequest::getVar("id");
		$idDirector = JRequest::getVar("idDirector");
		
		$modelo = $this->getModel("films");
		
		$correcto = $modelo->añadirDirector($idPelicula, $idDirector);

        if ($correcto) {
            $aviso = "La actualización se ha realizado con exito ";
        } else {
            $aviso = "Error en la actualizacion ";
        }
        
		$enlace = 'index.php?option=com_peliculas&controller=films&task=edit&cid[]='.$idPelicula;
        $this->setRedirect($enlace, $aviso);
	}
	
	function insertarActor() {
		$id = JRequest::getVar("id");
		$modelo = $this->getModel("films");
        $film = $modelo->obtenerPeliculaPorId($id);
		
		$modeloFamosos = $this->getModel("famosos");
		$famosos = $modeloFamosos->obtenerTodosLosFamosos();	
			
		$vista = $this->getView('films', 'html');
		$vista->assignRef("film",$film);
		$vista->assignRef("famosos",$famosos);
		$vista->insertarActor();
	}
	
	function grabarActor() {
		$idPelicula = JRequest::getVar("id");
		$idActor = JRequest::getVar("idActor");
		$modelo = $this->getModel("actoresPelicula");

		$correcto = $modelo->insertar($idActor,$idPelicula);
		
		if ($correcto) {
            $aviso = "La actualización se ha realizado con exito ";
        } else {
            $aviso = "Error en la actualizacion ";
        }
        
		$enlace = 'index.php?option=com_peliculas&controller=films&task=edit&cid[]='.$idPelicula;
        $this->setRedirect($enlace, $aviso);
	}
	
	function insertarCategoria() {
		$id = JRequest::getVar("id");
		$modelo = $this->getModel("films");
        $film = $modelo->obtenerPeliculaPorId($id);
		
		$modeloCategoria = $this->getModel("categorias");
		$categorias = $modeloCategoria->obtenerTodasLasCategorias();
		
		$vista = $this->getView("films","html");
		$vista->assignRef("film",$film);
		$vista->assignRef("categorias",$categorias);
		$vista->insertarCategoria();
	}
	
	function grabarCategoria() {
		$idPelicula = JRequest::getVar("id");
		$idCategoria = JRequest::getVar("idCategoria");
		
		$modeloPeliculasCategorias = $this->getModel("peliculasCategorias");
		
		$correcto = $modeloPeliculasCategorias->add($idPelicula,$idCategoria);
		if ($correcto) {
            $aviso = "La inserción se ha realizado con exito ";
        } else {
            $aviso = "Error en la insercion ";
        }
		$enlace = 'index.php?option=com_peliculas&controller=films&task=edit&cid[]='.$idPelicula;
        $this->setRedirect($enlace, $aviso);
	}
	
	function borrarCategoria() {
		$cid = JRequest::getVar("cid", 0, "", "array");
		$idObj = JRequest::getVar("idObj");
		
		$modelo = $this->getModel("films");
        $film = $modelo->obtenerPeliculaPorId($cid[0]);
		
		$modeloPeliculasCategorias = $this->getModel("peliculasCategorias");
		
		$correcto = $modeloPeliculasCategorias->deleteByPeliculaCategoria($film["id"],$idObj);
		
		if ($correcto) {
            $aviso = "La categoría se borró con éxito ";
        } else {
            $aviso = "Error en el borrado";
        }
		$enlace = 'index.php?option=com_peliculas&controller=films&task=edit&cid[]='.$film["id"];
        $this->setRedirect($enlace, $aviso);
		
	}
	
	function borrarDirector() {
		$cid = JRequest::getVar("cid", 0, "", "array");
		$modelo = $this->getModel("films");
        $film = $modelo->obtenerPeliculaPorId($cid[0]); 
		
		$correcto = $modelo->quitarDirector($film["id"]);
		
		if ($correcto) {
            $aviso = "El director se borró con éxito ";
        } else {
            $aviso = "Error en el borrado";
        }
		$enlace = 'index.php?option=com_peliculas&controller=films&task=edit&cid[]='.$film["id"];
        $this->setRedirect($enlace, $aviso);
	}
	
	function borrarActor() {
		$cid = JRequest::getVar("cid", 0, "", "array");
		$idObj = JRequest::getVar("idObj");
		
		$modelo = $this->getModel("films");
        $film = $modelo->obtenerPeliculaPorId($cid[0]);
		
		$modeloActoresPelicula = $this->getModel("actoresPelicula");
		
		$correcto = $modeloActoresPelicula->borrarPorPeliculaYFamoso($film["id"],$idObj) ;
		
		if ($correcto) {
            $aviso = "El actor se borró con éxito ";
        } else {
            $aviso = "Error en el borrado";
        }
		$enlace = 'index.php?option=com_peliculas&controller=films&task=edit&cid[]='.$film["id"];
        $this->setRedirect($enlace, $aviso);
	}
}

?>
