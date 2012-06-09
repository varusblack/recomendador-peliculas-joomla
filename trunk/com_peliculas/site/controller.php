<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class PeliculasController extends JController {

    function __construct($config = array()) {
        parent::__construct($config);
        $this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR . DS . 'models');
    }

    function votar() {
        $modeloVotaciones = $this->getModel('votacionesPelicula');
        $modeloCategorias = $this->getModel('peliculasCategorias');

        $categoriasPeliculas = array();
        $identificadores = array();
        $user = & JFactory::getUser();

        $peliculasSinVotar = $modeloVotaciones->obtenerPeliculasAleatoriasNoVotadasPorUsuario($user->id);
        foreach ($peliculasSinVotar as $peli) {
            $idPelicula = $peli["id"];
            $identificadores[] = $idPelicula;
            $categs = $modeloCategorias->obtenerCategoriasDePeliculas($idPelicula);
            $categoriasPeliculas[$idPelicula] = $categs;
        }

        $vista = $this->getView("votarPeliculas", "html");
        $vista->assignRef("categoriasPeliculas", $categoriasPeliculas);
        $vista->assignRef("peliculas", $peliculasSinVotar);
        $vista->assignRef("identificadores", $identificadores);
        $vista->display();
    }

    function cambiarVoto() {
        $idPelicula = JRequest::getVar('id');
        $puntuacion = JRequest::getVar('puntuacion');
        $user = & JFactory::getUser();
        $idUsuario = $user->id;

        $modeloVotaciones = $this->getModel('votacionesPelicula');

        $modeloVotaciones->actualizarVoto($idUsuario, $idPelicula, $puntuacion);

        $this->verDetalles();
    }

    function vervotadas() {
        global $mainframe, $option;

        $modeloVotaciones = $this->getModel('votacionesPelicula');

        $categoriasPeliculas = array();
        $user = & JFactory::getUser();

        $peliculasVotadas = $modeloVotaciones->obtenerPeliculasVotadasPorUsuario($user->id, true);
        $todasPeliculasVotadas = $modeloVotaciones->obtenerPeliculasVotadasPorUsuario($user->id);

        $pagination = $modeloVotaciones->getPagination($todasPeliculasVotadas);
        $filter_order = $mainframe->getUserStateFromRequest($option . '.peliculas.filter_order', 'filter_order', '', 'word');
        $filter_order_Dir = $mainframe->getUserStateFromRequest($option . '.peliculas.filter_order_Dir', 'filter_order_Dir', '', 'word');
        $filter_state = $mainframe->getUserStateFromRequest($option . '.peliculas.filter_state', 'filter_state', '', 'word');

        $vista = $this->getView("films", "html");
        $vista->assignRef("pagination", $pagination);
        $vista->assignRef("peliculas", $peliculasVotadas);
        $vista->assignRef("filter_order", $filter_order);
        $vista->assignRef("filter_order_Dir", $filter_order_Dir);
        $vista->assignRef("filter_state", $filter_state);
        $vista->vervotadas();
    }

    function verDetalles() {
        $user = & JFactory::getUser();
        $idPelicula = JRequest::getVar('id');
        $modeloPelicula = $this->getModel('films');
        $modeloVotacionesPelicula = $this->getModel('votacionesPelicula');
        $modeloActoresPelicula = $this->getModel('actoresPelicula');
        $modeloPeliculasCategorias = $this->getModel('peliculasCategorias');
        $modeloFamosos = $this->getModel('famosos');

        $pelicula = $modeloPelicula->obtenerPeliculaPorId($idPelicula);
        $otrosDatosPelicula = $modeloVotacionesPelicula->obtenerUnicaPeliculaVotadaPorUsuario($user->id, $idPelicula);
        $actores = $modeloActoresPelicula->obtenerActoresDePelicula($pelicula["id"]);
        $categoriasPelicula = $modeloPeliculasCategorias->obtenerCategoriasDePeliculas($pelicula["id"]);
        $director = $modeloFamosos->obtenerFamosoPorId($pelicula["idDirector"]);

        $vista = $this->getView('films', 'html');

        if (count($otrosDatosPelicula) > 0) {
            $vista->assignRef("otrosdatos", $otrosDatosPelicula);
        }
        $vista->assignRef("pelicula", $pelicula);
        $vista->assignRef("actores", $actores);
        $vista->assignRef("categorias", $categoriasPelicula);
        $vista->assignRef("director", $director);

        $vista->verDetalles();
    }

    function votarMasivo() {
        $user = & JFactory::getUser();
        $idUsuario = $user->id;
        $identificadores = JRequest::getVar("identificadores");
        $identificadores = unserialize(base64_decode($identificadores));
        $puntuaciones = array();

        $modeloVotaciones = $this->getModel('votacionesPelicula');

        foreach ($identificadores as $identificador) {
            $puntuacion = JRequest::getVar('puntuacion' . $identificador);
            $puntuaciones[$identificador] = $puntuacion;
        }

        foreach ($puntuaciones as $identificador => $puntuacion) {
            if (strcmp($puntuacion, "no") != 0) {
                $modeloVotaciones->votarPelicula($idUsuario, $identificador, $puntuacion);
            }
        }

        $this->votar();
    }

    function prepararBusquedaAvanzada() {
        $modeloCategoria = $this->getModel("categorias");
        $categorias = $modeloCategoria->obtenerTodasLasCategorias();

        $vista = $this->getView('films', 'html');
        $vista->assignRef("categorias", $categorias);
        $vista->busquedaYResultados();
    }

    function busquedaAvanzada() {
        global $mainframe, $option;

        $peliculas = array();
        $todasLasPeliculas = array();
        $campos = array();
        $camposPrevios = array();

        $modeloFilms = $this->getModel("films");
        $modeloCategoria = $this->getModel("categorias");

        $titulo = JRequest::getVar("titulo");
        $tituloEspanol = JRequest::getVar("tituloEspanol");
        $anno = JRequest::getVar("anno");
        $nombreDirector = JRequest::getVar("nombreDirector");
        $idCategoria = JRequest::getVar("idCategoria");
        $nombreActor1 = JRequest::getVar("nombreActor1");
        $nombreActor2 = JRequest::getVar("nombreActor2");
        $nombreActor3 = JRequest::getVar("nombreActor3");
        $paginacion = JRequest::getVar("paginacion");

        if ($paginacion == NULL) {

            if (strlen($titulo) > 1) {
                $campos["titulo"] = $titulo;
                $camposPrevios["titulo"] = $titulo;
            }

            if (strlen($tituloEspanol) > 1) {
                $campos["tituloEspanol"] = $tituloEspanol;
                $camposPrevios["tituloEspanol"] = $tituloEspanol;
            }

            if (strlen($anno) > 1) {
                $campos["anno"] = $anno;
                $camposPrevios["anno"] = $anno;
            }

            if (strlen($nombreDirector) > 1) {
                $campos["nombreDirector"] = $nombreDirector;
                $camposPrevios["nombreDirector"] = $nombreDirector;
            }

            if ($idCategoria != 0) {
                $campos["idCategoria"] = $idCategoria;
                $camposPrevios["idCategoria"] = $idCategoria;
            }

            if (strlen($nombreActor1) > 1) {
                $campos["nombreActor1"] = $nombreActor1;
                $camposPrevios["nombreActor1"] = $nombreActor1;
            }

            if (strlen($nombreActor2) > 1) {
                $campos["nombreActor2"] = $nombreActor2;
                $camposPrevios["nombreActor2"] = $nombreActor2;
            }

            if (strlen($nombreActor3) > 1) {
                $campos["nombreActor3"] = $nombreActor3;
                $camposPrevios["nombreActor3"] = $nombreActor3;
            }
        } else {
            $camposPrevios = JRequest::getVar("camposPrevios");
            $camposPrevios = unserialize(base64_decode($camposPrevios));
        }



        $categorias = $modeloCategoria->obtenerTodasLasCategorias();

        $vista = $this->getView('films', 'html');
        $vista->assignRef("categorias", $categorias);

        if ($paginacion == NULL) {
            if (count($campos) > 0) {
                $peliculas = $modeloFilms->obtenerPeliculasPorCampos($campos, true);
                $todasLasPeliculas = $modeloFilms->obtenerPeliculasPorCampos($campos);
            }
        } else {
            $peliculas = $modeloFilms->obtenerPeliculasPorCampos($camposPrevios, true);
            $todasLasPeliculas = $modeloFilms->obtenerPeliculasPorCampos($camposPrevios);
        }


        $pagination = $modeloFilms->getPagination($todasLasPeliculas);
        $filter_order = $mainframe->getUserStateFromRequest($option . '.peliculas.filter_order', 'filter_order', '', 'word');
        $filter_order_Dir = $mainframe->getUserStateFromRequest($option . '.peliculas.filter_order_Dir', 'filter_order_Dir', '', 'word');
        $filter_state = $mainframe->getUserStateFromRequest($option . '.peliculas.filter_state', 'filter_state', '', 'word');
        $search = $mainframe->getUserStateFromRequest($option . '.peliculas.search', 'search', '', 'word');

        $vista->assignRef("camposPrevios", $camposPrevios);
        $vista->assignRef("pagination", $pagination);
        $vista->assignRef("filter_order", $filter_order);
        $vista->assignRef("filter_order_Dir", $filter_order_Dir);
        $vista->assignRef("filter_state", $filter_state);
        $vista->assignRef("peliculas", $peliculas);
        $vista->busquedaYResultados();
    }
    
    public function recomendar(){
        $modeloUsuarios = $this->getModel('usuarios');
        $modeloVotos = $this->getModel('votacionesPelicula');
		$modeloPeliculas = $this->getModel('films');
		$recomendadas=array();
        
        
        $user = & JFactory::getUser();
        $idUsuario=$user->id;

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
                $recomendadas[]=$idPelicula;
                
            }
        }
        
        $vista = $this->getView('films', 'html');
		$peliculas=array();
		foreach($recomendadas as $idPelicula){
			$peliculas[]=$modeloPeliculas->obtenerPeliculaPorId($idPelicula);
		}
		
        $vista->assignRef("peliculas", $peliculas);
        $vista->recomendadas();

    }

}

?>