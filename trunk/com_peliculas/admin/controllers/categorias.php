<?php

defined('_JEXEC') or die("Restricted access");

jimport('joomla.application.component.controller');

class PeliculasControllerCategorias extends JController {

    function __construct($config = array()) {
        parent::__construct($config);

        $this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR . DS . "categorias");
    }

    function display() {
        $modelo = $this->getModel('categorias');
        $categorias = $modelo->obtenerCategoriasLimites();


        $vista = $this->getView('Categorias', 'html');
        // Get data from the model

        $pagination = $modelo->getPagination();

        // push data into the template

        $vista->assignRef('pagination', $pagination);
        $vista->assignRef('categorias', $categorias);
        $vista->display();
    }

    function add() {
        $vista = $this->getView('Categorias', 'html');
        $vista->add();
    }

    function edit() {
        $cid = JRequest::getVar('cid', 0, '', 'array');
        $modelo = $this->getModel('categorias');
        $categoria = $modelo->dameCategoria($cid[0]);

        $vista = $this->getView('Categorias', 'html');
        $vista->assignRef('categoria', $categoria);
        $vista->edit();
    }

    function save() {
        $id = JRequest::getVar('id');
        $modelo = $this->getModel('categorias');
        $nombre = JRequest::getVar('nombreCategoria');
        if ($id != '') {



            $correcto = $modelo->updateCategoria($nombre, $id);

            if ($correcto) {
                $aviso = "Se actualizó la categoría correctamente";
            } else {
                $aviso = "Se ha producido un error al actualizar la categoría";
            }
        } else {
            $correcto = $modelo->addCategoria($nombre);

            if ($correcto) {
                $aviso = "La categoría se insertó correctamente";
            } else {
                $aviso = "Se ha producido un error al insertar la categoría";
            }
        }
        $enlace = 'index.php?option=com_peliculas&controller=categorias';
        $this->setRedirect($enlace, $aviso);
    }

    function remove() {
        $cid = JRequest::getVar('cid', 0, '', 'array');
        $modelo = $this->getModel('categorias');
        $categorias = array();
        foreach ($cid as $idCategoria) {
            $categoria = $modelo->dameCategoria($idCategoria);
            $categorias[] = $categoria;
        }

        $vista = $this->getView('Categorias', 'html');
        $vista->assignRef('categorias', $categorias);
        $vista->remove();
    }

    function processRemove() {
        $elementsToDelete = JRequest::getVar('elementsToDelete');
        $elementsToDelete = unserialize(base64_decode($elementsToDelete));
        
        $modeloCategorias = $this->getModel('categorias');
        $modeloPeliculasCategorias=$this->getModel('peliculasCategorias');
        
        foreach ($elementsToDelete as $element) {
            $modeloCategorias->deleteCategoria($element["id"]);
            $modeloPeliculasCategorias->deleteByCategoria($element["id"]);
        }
        $correcto=true;
        if ($correcto) {
            $aviso = "Se borraron los elementos seleccionados";
        } else {
            $aviso = "No se borraron los elementos seleccionados";
        }

        $enlace = 'index.php?option=com_peliculas&controller=categorias';
        $this->setRedirect($enlace, $aviso);
    }

}

?>
