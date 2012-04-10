<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class LibrosController extends JController {

    function __construct() {
        parent::__construct();

        $this->addModelPath(JPATH_COMPONENT_SITE . DS . 'models');
    }

    function display() {
        $modelo = $this->getModel('Libros');
        $libros = $modelo->dameTodosLosLibros();

        $vista = $this->getView('libros', 'html');
        $vista->assignRef('libros', $libros);
        $vista->display();
    }

    function edit() {
        $cid = JRequest::getVar('cid', '', 'array');
        $modelo = $this->getModel('libros');
        $libro = $modelo->dameLibro($cid[0]);

        $vista = $this->getView('libros', 'html');
        $vista->assignRef('libro', $libro);
        $vista->edit();
    }

    function save() {
        $id = JRequest::getVar('id');
        $modelo = $this->getModel('libros');
        $titulo = JRequest::getVar('titulo');
        if ($id != '') {



            $correcto = $modelo->actualizaLibro($id, $titulo);

            if ($correcto) {
                $aviso = "Se realizaron los cambios";
            } else {
                $aviso = "Error al actualizar";
            }
        } else {
            $correcto = $modelo->grabaLibro($titulo);

            if ($correcto) {
                $aviso = "Se inserto el libro";
            } else {
                $aviso = "Error al insertar";
            }
        }
        die($aviso);
        $enlace = 'index.php?option=com_libros';
        $this->setRedirect($enlace, $aviso);
    }

    function remove() {

        $modelo = $this->getModel('libros');
        $cid = JRequest::getVar('cid', '', 'array');

        $correcto = true;
        foreach ($cid as $id) {
            $resultado = $modelo->eliminaLibro($id);
            if (!$resultado) {
                $correcto = false;
            }
        }

        if ($correcto) {
            $aviso = "Se realizaron los cambios";
        } else {
            $aviso = "Error al actualizar";
        }

        $enlace = 'index.php?option=com_libros';
        $this->setRedirect($enlace, $aviso);
    }

    function add() {
        $vista = $this->getView('libros', 'html');
        $vista->add();
    }

}

?>
