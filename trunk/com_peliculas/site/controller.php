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
        $user = & JFactory::getUser();
        $idUsuario = $user->id;
        $modeloVotacion = $this->getModel('votacionesPelicula');
        $peliculas = $modeloVotacion->obtenerPeliculasVotadasPorUsuario($idUsuario);

        $idsPeliculas = array();
        foreach ($peliculas as $value) {
            $idsPeliculas[] = $value["id"];
        }

        $resultados = array();
        foreach ($idsPeliculas as $id) {
            $resultados[] = $this->obtenerDatosPorId($id, $idUsuario);
        }

        $texto = $this->mostrar($resultados);

        $vista = $this->getView("films", "html");
        $vista->assignRef('texto', $texto);
        $vista->vervotadas();
    }

    function verDetalles() {
        $user = & JFactory::getUser();


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

        $vista->assignRef("camposPrevios", $camposPrevios);
        $vista->assignRef("pagination", $pagination);
        $vista->assignRef("filter_order", $filter_order);
        $vista->assignRef("filter_order_Dir", $filter_order_Dir);
        $vista->assignRef("filter_state", $filter_state);
        $vista->assignRef("peliculas", $peliculas);
        $vista->busquedaYResultados();
    }

    public function recomendar() {
        $modeloUsuarios = $this->getModel('usuarios');
        $modeloUsuarios->calculaLongitudVector();

        $modeloVotos = $this->getModel('votacionesPelicula');
        $modeloPeliculas = $this->getModel('films');
        $recomendadas = array();


        $user = & JFactory::getUser();
        $idUsuario = $user->id;

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
                $recomendadas[] = $idPelicula;
            }
        }

        $vista = $this->getView('films', 'html');
        $peliculas = array();
        foreach ($recomendadas as $idPelicula) {
            $peliculas[] = $modeloPeliculas->obtenerPeliculaPorId($idPelicula);
        }

        $vista->assignRef("peliculas", $peliculas);
        $vista->recomendadas();
    }
    function obtenerDatosPorId($idFilm, $idUser = NULL) {
    $modeloFilms = $this->getModel('films');
    $peliculaResultado = $modeloFilms->ObtenerPeliculaPorId($idFilm);

    $modeloFamosos = $this->getModel('famosos');
    $directorResultado = $modeloFamosos->obtenerFamosoPorId($peliculaResultado["idDirector"]);

    $modeloCategorias = $this->getModel('peliculasCategorias');
    $categoriasResultado = $modeloCategorias->obtenerCategoriasDePeliculas($peliculaResultado["id"]);

    $modeloActores = $this->getModel('actoresPelicula');
    $actoresResultado = $modeloActores->obtenerActoresDePelicula($peliculaResultado["id"]);

    $idPelicula = $peliculaResultado["id"];
    $titulo = $peliculaResultado["titulo"];
    $tituloEspanol = $peliculaResultado["tituloEspanol"];
    $anno = $peliculaResultado["anno"];
    $director = $directorResultado["nombre"];
    $categorias = '';

    for ($i = 0; $i < count($categoriasResultado); $i++) {
        if ($i != (count($categoriasResultado) - 1)) {
            $categorias = $categorias . $categoriasResultado[$i]["categoria"] . ", ";
        } else {
            $categorias = $categorias . $categoriasResultado[$i]["categoria"];
        }
    }

    $actores = '';

    for ($i = 0; $i < count($actoresResultado); $i++) {
        if ($i != (count($actoresResultado) - 1)) {
            $actores = $actores . $actoresResultado[$i]["nombre"] . ", ";
        } else {
            $actores = $actores . $actoresResultado[$i]["nombre"];
        }
    }

    $cartel = "/media/com_peliculas/imagenes/$idPelicula.jpg";
    $puntuacion = NULL;

    if ($idUser != NULL) {
        $modeloVotaciones = $this->getModel('votacionesPelicula');
        $peliculaVotadaResultado = $modeloVotaciones->obtenerUnicaPeliculaVotadaPorUsuario($idUser, $idPelicula);
        $puntuacion = $peliculaVotadaResultado["puntuacion"];
    }
    $resultado = array('idPelicula' => $idPelicula,
        'titulo' => $titulo,
        'tituloEspanol' => $tituloEspanol,
        'anno' => $anno,
        'director' => $director,
        'categorias' => $categorias,
        'actores' => $actores,
        'cartel' => $cartel,
        'puntuacion' => $puntuacion);

    return $resultado;
}

// 	Devuelve un texto HTML para imprimir en pantalla
function mostrar($resultados) {

    $pagina = '';
    foreach ($resultados as $resultado) {
        $pagina.= $this->obtenerCadena($resultado);
    }

    return $pagina;
}

function obtenerCadena($resultado) {
    ob_start();
    ?>
    <div class="Post">
        <div class="Post-tl"></div>
        <div class="Post-tr"></div>
        <div class="Post-bl"></div>
        <div class="Post-br"></div>
        <div class="Post-tc"></div>
        <div class="Post-bc"></div>
        <div class="Post-cl"></div>
        <div class="Post-cr"></div>
        <div class="Post-cc"></div>
        <div class="Post-body">
            <div class="Post-inner">
                <div class="PostContent">
                    <h3><?php echo $resultado["tituloEspanol"] . " (" . $resultado["titulo"] . ")" ?></h3>

                    <div>
                        <span class="indicador">Año: </span>
                        <span><?php echo $resultado["anno"] ?></span>
                    </div>

                    <div>
                        <span class="indicador">Categorías: </span>
                        <span><?php echo $resultado["categorias"] ?></span>
                    </div>

                    <div>
                        <span class="indicador">Director: </span>
                        <span><?php echo $resultado["director"] ?></span>
                    </div>

                    <div>
                        <span class="indicador">Actores: </span>
                        <span><?php echo $resultado["actores"] ?></span>
                    </div>

    <?php if (isset($resultado["puntuacion"])) { ?>
                        <span class="indicador">Puntuación: </span>
                        <select name="puntuacion" id="puntuacion" onchange="">
                        <?php
                        for ($i = 1; $i < 6; $i++) {
                            if ($i . ".00" == $resultado["puntuacion"]) {
                                ?>
                                    <option selected value="<?php echo $i . ".00"; ?>"><?php echo $i . ".00"; ?></option>
                                    <?php } else {
                                    ?>
                                    <option value="<?php echo $i . ".00"; ?>"><?php echo $i . ".00"; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <?php } ?>

                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

}


?>

