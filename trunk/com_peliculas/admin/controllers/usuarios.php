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

        $tablaUsuarios = array();

        $usuarioACalcular = $modeloUsuarios->dameUsuario($idUsuario);
        $votosUsuario = $modeloVotos->obtenerVotosUsuario($idUsuario);

        $usuarioAEstudiar = array();
        foreach ($votosUsuario as $voto) {
            $usuarios = $modeloVotos->obtenerUsuariosQueHanVotadoUnaPelicula($voto["idPelicula"]);
            foreach ($usuarios as $idU => $usuario) {
                if ($usuario["idUsuario"] != $idUsuario) {
                    $usuarioAEstudiar[$idU][$voto["idPelicula"]] = $usuario["voto"];
                }
            }
            $productoDeUnaPelicula = 1;

            foreach ($usuarioAEstudiar as $idU => $usuario) {
                print_r($usuario);
                if (!isset($usuario[$voto["idPelicula"]])) {
                    echo "<br>" . $usuario[$voto["idPelicula"]];
                    $productoDeUnaPelicula = $productoDeUnaPelicula * $usuario[$voto["idPelicula"]];
                }
            }
            echo "<br>" . $voto["idPelicula"] . " - $productoDeUnaPelicula";
            $numerador = $numerador + $productoDeUnaPelicula;
        }
        echo "<br>Terminado " . microtime() . " usando " . memory_get_usage();
    }

}

?>
