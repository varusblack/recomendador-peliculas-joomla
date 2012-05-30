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
        echo "Empezando ".microtime();
        $modeloUsuarios = $this->getModel('usuarios');
        $modeloVotos = $this->getModel('votacionesPelicula');
		//$modeloVecindario=$this->getModel('vecindarios');
		
		//$modeloVecindario->borrarVecindarioPorUsuario($idUsuario);

        $tablaUsuarios = array();

        $usuarioACalcular = $modeloUsuarios->dameUsuario($idUsuario);
        $votosUsuario = $modeloVotos->obtenerVotosUsuario($idUsuario);
		$votosPorPeliculas=array();

		$usuarioAEstudiar=array();

		
        foreach ($votosUsuario as $voto) {
			$votosPorPeliculas[$voto["idPelicula"]]=$voto["voto"];
            $usuarios = $modeloVotos->obtenerUsuariosQueHanVotadoUnaPelicula($voto["idPelicula"]);
            foreach ($usuarios as $idU=>$usuario) {
				if($usuario["idUsuario"]!=$idUsuario){
					$usuarioAEstudiar[$usuario["idUsuario"]][$voto["idPelicula"]] = $usuario["voto"];
					
				}
            }
			$i=0;
	    }
		foreach($usuarioAEstudiar as $idU=>$usuario){
			$numerador=0;
			$vector=0;
			foreach($usuario as $idPelicula=>$voto){
				$numerador+=$voto*$votosPorPeliculas[$idPelicula];
				$vector+=$voto*$voto;
			}
			$vector=sqrt($vector);
			$usuarioAEstudiar[$idU]["numerador"]=$numerador;
			$usuarioAEstudiar[$idU]["denominador"]=$vector*$usuarioACalcular["vector"];
			$usuarioAEstudiar[$idU]["coseno"]=$usuarioAEstudiar[$idU]["numerador"]/$usuarioAEstudiar[$idU]["denominador"];
		}
		
		foreach($usuarioAEstudiar as $idU=>$usuario){
			if($usuario["coseno"]>0.85){
				echo "<br>".$idU."-".$usuario["coseno"];
			}
		}
		
		echo "<br>Terminado: ".microtime()." usando: ".memory_get_usage();

    }

}

?>
