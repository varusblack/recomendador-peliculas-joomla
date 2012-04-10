<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class FamososController extends JController {

    function display() {
        $modelo = $this->getModel('Famoso');
        $nombre = $modelo->obtenerLibroPorId(3);

        $vista = $this->getView('Famoso', 'html');
        $vista->assign('nombre', $nombre);
        $vista->display();
    }

    function leeLibro() {
        $vista = $this->getView('libros', 'html');
        $vista->leeLibro();
    }

    function grabaLibro() {
        $titulo = JRequest::getVar('titulo');
        $modelo = $this->getModel('libros');

        if ($modelo->grabaLibro($titulo)) {
            $aviso = 'Se realizaron los cambios';
        } else {
            $aviso = 'Error al grabar';
        }

        $link = 'index.php?option=com_libros';
        $this->setRedirect($link, $aviso);
    }

}

?>