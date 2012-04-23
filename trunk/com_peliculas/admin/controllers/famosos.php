<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class PeliculasControllerFamosos extends JController {

    function __construct($config = array()) {
        parent::__construct($config);
        $this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR . DS . 'famosos');
    }

    function display() {
        $modelo = $this->getModel("famosos");
        $famosos = $modelo->obtenerFamososLimites();

        $vista = $this->getView("famosos", "html");
        $pagination = $modelo->getPagination();
        $vista->assignRef("pagination", $pagination);
        $vista->assignRef("famosos", $famosos);
        $vista->display();
    }

    function edit() {
        $cid = JRequest::getVar("cid", 0, "", "array");
        $modelo = $this->getModel("famosos");
        $famoso = $modelo->obtenerFamosoPorId($cid[0]);

        $vista = $this->getView("famosos", "html");
        $vista->assignRef("famoso", $famoso);
        $vista->edit();
    }

    function remove() {
//        $modelo = $this->getModel("famosos");
//        $cid = JRequest::getVar("cid", 0, "array");
//
//        $correcto = true;
//        foreach ($cid as $id) {
//            $resultado = $modelo->borrarFamoso($id);
//            if (!$resultado) {
//                $correcto = false;
//            }
//        }
//
//        if ($correcto) {
//            $aviso = "Se realizaron los cambios";
//        } else {
//            $aviso = "Error al actualizar";
//        }
//
//        $enlace = "index.php?option=com_peliculas&controller=famosos";
//        $this->setRedirect($enlace, $aviso);
        
        
        $cid = JRequest::getVar('cid', 0, '', 'array');
        $modelo = $this->getModel('famosos');
        $famosos = array();
        foreach ($cid as $idFamoso) {
            $famoso = $modelo->obtenerFamosoPorId($idFamoso);
            $famosos[] = $famoso;
        }

        $vista = $this->getView('Famosos', 'html');
        $vista->assignRef('famosos', $famosos);
        $vista->remove();
    }

    function save() {
        $id = JRequest::getVar("id");
        $modelo = $this->getModel("Famosos");
        $nombre = JRequest::getVar("nombre");

        if ($id != "") {
            $correcto = $modelo->actualizarFamoso($id, $nombre);
            if ($correcto) {
                $aviso = "La actualización se ha realizado con exito";
            } else {
                $aviso = "Error en la actualizacion";
            }
        } else {
            $correcto = $modelo->insertarFamoso($nombre);
            if ($correcto) {
                $aviso = "La insercion se ha realizado con exito";
            } else {
                $aviso = "Error en la insercion";
            }
        }

        $enlace = 'index.php?option=com_peliculas&controller=famosos';
        $this->setRedirect($enlace, $aviso);
    }

    function add() {
        $vista = $this->getView('famosos', 'html');
        $vista->add();
    }
    
    function processRemove() {
        $elementsToDelete = JRequest::getVar('elementsToDelete');
        $elementsToDelete = unserialize(base64_decode($elementsToDelete));
        
        $modeloFamosos = $this->getModel('famosos');
        $modeloActoresPelicula=$this->getModel('actoresPelicula');
        $modeloPeliculas=$this->getModel('films');
        
        foreach ($elementsToDelete as $element) {
            $modeloFamosos->borrarFamoso($element["id"]);
            $modeloActoresPelicula->borrarPorFamoso($element["id"]);
            $modeloPeliculas->quitarDirector($element["id"]);
        }
        $correcto=true;
        if ($correcto) {
            $aviso = "Se borraron los elementos seleccionados";
        } else {
            $aviso = "No se borraron los elementos seleccionados";
        }

        $enlace = 'index.php?option=com_peliculas&controller=famosos';
        $this->setRedirect($enlace, $aviso);
    }

}

?>