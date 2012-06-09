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
        echo "Empezando " . microtime();
        echo "<br>Calculando para $idUsuario";
        $modeloUsuarios = $this->getModel('usuarios');
        $modeloVotos = $this->getModel('votacionesPelicula');



        $tablaUsuarios = array();

        $usuarioACalcular = $modeloUsuarios->dameUsuario($idUsuario);

        $votosUsuario = $modeloVotos->obtenerVotosUsuario($idUsuario);  //Peliculas a las que ha votado el usuario
        $votosPorPeliculas = array();

        $usuarioAEstudiar = array();

        foreach ($votosUsuario as $voto) {
            //Por cada película que ha votado el usuario que al que estamos buscando vecindario
            $votosPorPeliculas[$voto["idPelicula"]] = $voto["voto"];
            //Guardamos en un array el voto a cada pelicula (clave: idPelicula, valor:voto)
            $usuarios = $modeloVotos->obtenerUsuariosQueHanVotadoUnaPelicula($voto["idPelicula"]);
            //Usuarios contiene los usuarios que hayan votado alguna película a la que haya votado al que estamos buscando vecindario
            foreach ($usuarios as $idU => $usuario) {
                //Por cada uno de estos usuarios
                if ($usuario["idUsuario"] != $idUsuario) {
                    //y si este usuario es distinto al que estamos buscando vecindario

                    $usuarioAEstudiar[$usuario["idUsuario"]][$voto["idPelicula"]] = $usuario["voto"];
                    //Guardamos en esta tabla los votos en los que coincide este usuario con los del usuario al que estamos buscando vecindario.
                }
            }
        }

        foreach ($usuarioAEstudiar as $idU => $usuario) {
            //Por cada usuario que ha visto alguna pelicula en común con el que le estamos buscando el vecindario
            $numerador = 0;
            $vector = 0;
            $suma = 0;
            $peliculas = 0;
            foreach ($usuario as $idPelicula => $voto) {
                //Por cada pelicula que este usuario haya visto
                $numerador+=$voto * $votosPorPeliculas[$idPelicula];
                //Multiplicamos los votos de las peliculas del usuario al que queremos buscar vecindario con el que estmos estudiando
                $vector+=$voto * $voto;
                //Vamos calculando la longitud del vector de cada usuario
            }
            $vector = sqrt($vector);
            //Hayamos la raiz cuadrada del vector
            $usuarioAEstudiar[$idU]["numerador"] = $numerador;
            //Guardamos el numerador en el array de usuarios a estudiar
            $usuarioAEstudiar[$idU]["denominador"] = $vector * $usuarioACalcular["vector"];
            //Hayamos el producto de las longitudes de los vectores del usuario a estudiar y del que queremos calcular el vecindario
            $usuarioAEstudiar[$idU]["coseno"] = $usuarioAEstudiar[$idU]["numerador"] / $usuarioAEstudiar[$idU]["denominador"];
            //Calculamos el coseno dividiendo el numerador por el denominador.
        }
        $vecindario = array();
        $peliculasNoVistas = array();

        $denominador = 1;

        foreach ($usuarioAEstudiar as $idU => $usuario) {
            if ($usuario["coseno"] > 0.85) {
                $vecindario[$idU]["coseno"] = $usuario["coseno"];
                $denominador = $denominador + $usuario["coseno"];
                $vecindario[$idU]["media"] = $modeloVotos->calculaMedia($idU);
            }
        }
        $usuarioAEstudiar = null;

        $miMedia = $modeloVotos->calculaMedia($idUsuario);

        foreach ($vecindario as $idU => $vecino) {

            foreach ($modeloVotos->obtenerPeliculasNoVistasDelVecino($idUsuario, $idU) as $pelicula) {
                $peliculasNoVistas[$pelicula["idPelicula"]][$idU] = $pelicula["voto"];
            }
        }

        foreach ($peliculasNoVistas as $idPelicula => $pelicula) {
            $numerador = 0;
            foreach ($vecindario as $idU => $usuario) {
                if (isset($pelicula[$idU])) {
                    $numerador+=($pelicula[$idU] - $usuario["media"]) * $usuario["coseno"];
                }
            }
            $peliculasNoVistas[$idPelicula]["prediccion"] = ($numerador / $denominador) + $miMedia;
        }

        foreach ($peliculasNoVistas as $idPelicula => $pelicula) {
            
            if ($pelicula["prediccion"] > 4) {
                echo "<br>$idPelicula - " . $pelicula["prediccion"];
                
            }
        }

        echo "<br>Denominador: $denominador";
        echo "<br>Terminado: " . microtime() . " usando: " . memory_get_usage();
    }

}

?>
