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

        $modelo2 = $this->getModel("famosos");
        $famosos = $modelo2->obtenerTodosLosFamosos();

        $vista = $this->getView("films", "html");
        $pagination = $modelo->getPagination();
        $vista->assignRef("pagination", $pagination);
        $vista->assignRef("films", $films);
        $vista->assignRef("famosos", $famosos);
        $vista->display();
    }

    function edit() {
        $cid = JRequest::getVar("cid", 0, "", "array");
        $modelo = $this->getModel("films");
        $film = $modelo->obtenerPeliculaPorId($cid[0]);

        $modeloFamosos = $this->getModel("famosos");
        $director = $modeloFamosos->obtenerFamosoPorId($film["idDirector"]);
        $famosos = $modeloFamosos->obtenerTodosLosFamosos();

        $modeloActoresPelicula = $this->getModel("actoresPelicula");
        $actores = $modeloActoresPelicula->obtenerActoresDePelicula($film["id"]);

        $modeloCategorias = $this->getModel("categorias");
        $categorias = $modeloCategorias->obtenerTodasLasCategorias();

        $modeloPeliculasCategorias = $this->getModel("peliculasCategorias");
        $categoriasPelicula = $modeloPeliculasCategorias->obtenerCategoriasDePeliculas($film["id"]);

        $vista = $this->getView("films", "html");
        $vista->assignRef("film", $film);
        $vista->assignRef("famosos", $famosos);
        $vista->assignRef("director", $director);
        $vista->assignRef("actores", $actores);
        $vista->assignRef("categorias", $categorias);
        $vista->assignRef("categoriasPelicula", $categoriasPelicula);
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
        $imdbUrl = JRequest::getVar("imdbUrl");
        $titulo2 = JRequest::getVar("titulo2");
        $tituloEsp = JRequest::getVar("tituloEsp");
        $urlCartel = JRequest::getVar("urlCartel");
        $idDirector = JRequest::getVar("idDirector");
        $idActor1 = JRequest::getVar("idActor1");
        $idActor2 = JRequest::getVar("idActor2");
        $idActor3 = JRequest::getVar("idActor3");
        $idActor4 = JRequest::getVar("idActor4");
        $idActor5 = JRequest::getVar("idActor5");
        $idCategoria1 = JRequest::getVar("idCategoria1");
        $idCategoria2 = JRequest::getVar("idCategoria2");
        $idCategoria3 = JRequest::getVar("idCategoria3");

        $modelo = $this->getModel("films");
        $modeloActoresPelicula = $this->getModel("actoresPelicula");
        $modeloPeliculasCategorias = $this->getModel("peliculasCategorias");

        if ($id != "") {
            $correcto = $modelo->actualizarPelicula($idPelicula, $titulo, $anno, $videoRelease, $imdbUrl, $titulo2, $tituloEsp, $urlCartel, $idDirector);

            $correcto1 = $modeloActoresPelicula->borrarPorPelicula($id);
            $correctoActor1 = true;
            $correctoActor2 = true;
            $correctoActor3 = true;
            $correctoActor4 = true;
            $correctoActor5 = true;
            $correctoCategoria1 = true;
            $correctoCategoria2 = true;
            $correctoCategoria3 = true;

            if (isset($idActor1)) {
                $correctoActor1 = $modeloActoresPelicula->insertar($idActor1, $id);
            }
            if (isset($idActor2)) {
                $correctoActor2 = $modeloActoresPelicula->insertar($idActor2, $id);
            }
            if (isset($idActor3)) {
                $correctoActor3 = $modeloActoresPelicula->insertar($idActor3, $id);
            }
            if (isset($idActor4)) {
                $correctoActor4 = $modeloActoresPelicula->insertar($idActor4, $id);
            }
            if (isset($idActor5)) {
                $correctoActor5 = $modeloActoresPelicula->insertar($idActor5, $id);
            }

            if (isset($idCategoria1)) {
                $correctoCategoria1 = $modeloPeliculasCategorias->add($id, $idCategoria1);
            }
            if (isset($idCategoria2)) {
                $correctoCategoria2 = $modeloPeliculasCategorias->add($id, $idCategoria2);
            }
            if (isset($idCategoria3)) {
                $correctoCategoria3 = $modeloPeliculasCategorias->add($id, $idCategoria3);
            }

            $todoCorrecto = $correcto && $correcto1 && $correctoActor1 && $correctoActor2 && $correctoActor3 && $correctoActor4 && $correctoActor5 && $correctoCategoria1 && $correctoCategoria2 && $correctoCategoria3;

            if ($todoCorrecto) {
                $aviso = "La actualización se ha realizado con exito ";
            } else {
                $aviso = "Error en la actualizacion ";
            }
        } else {
            $correcto = $modelo->insertarPelicula($titulo, $anno, $videoRelease, $imdbUrl, $titulo2, $tituloEsp, $urlCartel, $idDirector);
            $correctoActor1 = true;
            $correctoActor2 = true;
            $correctoActor3 = true;
            $correctoActor4 = true;
            $correctoActor5 = true;
            $correctoCategoria1 = true;
            $correctoCategoria2 = true;
            $correctoCategoria3 = true;

            if (isset($idActor1)) {
                $correctoActor1 = $modeloActoresPelicula->insertar($idActor1, $id);
            }
            if (isset($idActor2)) {
                $correctoActor2 = $modeloActoresPelicula->insertar($idActor2, $id);
            }
            if (isset($idActor3)) {
                $correctoActor3 = $modeloActoresPelicula->insertar($idActor3, $id);
            }
            if (isset($idActor4)) {
                $correctoActor4 = $modeloActoresPelicula->insertar($idActor4, $id);
            }
            if (isset($idActor5)) {
                $correctoActor5 = $modeloActoresPelicula->insertar($idActor5, $id);
            }

            if (isset($idCategoria1)) {
                $correctoCategoria1 = $modeloPeliculasCategorias->add($id, $idCategoria1);
            }
            if (isset($idCategoria2)) {
                $correctoCategoria2 = $modeloPeliculasCategorias->add($id, $idCategoria2);
            }
            if (isset($idCategoria3)) {
                $correctoCategoria3 = $modeloPeliculasCategorias->add($id, $idCategoria3);
            }

            $todoCorrecto = $correcto && $correcto1 && $correctoActor1 && $correctoActor2 && $correctoActor3 && $correctoActor4 && $correctoActor5 && $correctoCategoria1 && $correctoCategoria2 && $correctoCategoria3;


            if ($todoCorrecto) {
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

        $modeloFamosos = $this->getModel("famosos");
        $famosos = $modeloFamosos->obtenerTodosLosFamosos();

        $modeloCategorias = $this->getModel("categorias");
        $categorias = $modeloCategorias->obtenerTodasLasCategorias();

        $vista->assignRef("categorias", $categorias);
        $vista->assignRef("famosos", $famosos);
        $vista->add();
    }

}

?>