<?php

defined('_JEXEC') or die("Restricted access");

jimport('joomla.application.component.controller');

class PeliculasControllerUsuarios extends JController {

    function __construct($config = array()) {
        parent::__construct($config);

        $this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR . DS . "usuarios");
        //$this->addModelPath(JPATH_ROOT.DS."administrator".DS."components".DS.)
    }

    function display() {
        $modelo = $this->getModel('usuarios');
        $usuarios = $modelo->obtenerUsuariosLimites();


        $vista = $this->getView('usuarios', 'html');
        // Get data from the model

        $pagination = $modelo->getPagination();

        // push data into the template

        $vista->assignRef('pagination', $pagination);
        $vista->assignRef('usuarios', $usuarios);
        $vista->display();
    }

    function calculaVecindario() {
        $cid = JRequest::getVar("cid", 0, "", "array");


        foreach ($cid as $idUsuario) {
            $this->calculaUnVecindario($idUsuario);
        }
    }

    private function calculaUnVecindario($idUsuario) {
        $modeloUsuarios = $this->getModel('usuarios');
        $modeloVotos = $this->getModel('votacionesPelicula');

        $usuarioACalcular = $modeloUsuarios->obtenerUsuarioPorId($idUsuario);
        $votosUsuario = $modeloVotos->obtenerVotosUsuario($idUsuario);
    }

}

?>
