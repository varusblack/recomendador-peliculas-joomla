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

    function verFamoso() {
        $vista = $this->getView('famosos', 'html');
        $vista->verFamoso();
    }

    function guardarFamoso() {
        $nombre = JRequest::getVar('nombre');
        $modelo = $this->getModel('famosos');

        if ($modelo->insertarFamoso($nombre)) {
            $aviso = 'Se realizaron los cambios';
        } else {
            $aviso = 'Error al grabar';
        }

        $link = 'index.php?option=com_famosos';
        $this->setRedirect($link, $aviso);
    }

}

?>