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

        $vista = $this->getView("films", "html");
        $vista->assignRef("film", $film);
        $vista->edit();
    }

    function remove() {
        $modelo = $this->getModel("films");
        $cid = JRequest::getVar("cid", "", "array");

        $correcto = true;
        foreach ($cid as $id) {
            $resultado = $modelo->borrarPelicula($id);
            if (!$resultado) {
                $correcto = false;
            }
        }

        if ($correcto) {
            $aviso = "Se realizaron los cambios";
        } else {
            $aviso = "Error al actualizar";
        }

        $enlace = "index.php?option=com_peliculas&controller=films";
        $this->setRedirect($enlace, $aviso);
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

        if ($id != "") {
            $correcto = $modelo->actualizarPelicula($idPelicula, $titulo, $anno, $videoRelease, $tituloEsp);

            if ($correcto) {
                $aviso = "La actualización se ha realizado con exito ";
            } else {
                $aviso = "Error en la actualizacion ";
            }
        } else {
            $correcto = $modelo->insertarPelicula($titulo, $anno, $videoRelease, $tituloEsp);

            if ($correcto) {
                $aviso = "La insercion se ha realizado con exito";
            } else {
                $aviso = "Error en la insercion";
            }
        }

        $enlace = 'index.php?option=com_peliculas&controller=films';
        $this->setRedirect($enlace, $aviso);
    }

    function add() {
        $vista = $this->getView('films', 'html');
        $vista->add();
    }
	
	function insertarDirector(){
		
	}

}

?>