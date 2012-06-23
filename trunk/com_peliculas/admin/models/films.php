<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class PeliculasModelFilms extends JModel {

    var $_total;
    var $_pagination;

    function __construct() {
	parent::__construct();
	global $mainframe, $option;
	$mainframe = JFactory::getApplication();
	$limit = $mainframe->getUserStateFromRequest($option . '.peliculas.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
	$limitstart = JRequest::getVar('limitstart', 0, '', 'int');
	$this->setState('limit', $limit);
	$this->setState('limitstart', $limitstart);
    }

//parametro $this->obtenerNumeroDePeliculas() intercambiable por count(arrayConResultados)
    function getPagination($resultados) {
	if (empty($this->_pagination)) {
	    jimport('joomla.html.pagination');
	    $this->_pagination = new JPagination(count($resultados), $this->getState('limitstart'), $this->getState('limit'));
	}
	return $this->_pagination;
    }

//hacer que la query sea una cadena a la que se le añadan los limites
    function obtenerPeliculasLimites() {
	$start = $this->getState('limitstart');
	$limit = $this->getState('limit');

	$db = &JFactory::getDbo();
	$query = "SELECT *,substring(anno,-4) FROM #__peliculas " . $this->_getWhereString() . " " . $this->_getOrderString() . " LIMIT $start,$limit";
	$db->setQuery($query);
	return $db->loadAssocList();
    }

    function obtenerTodasLasPeliculas($limites = NULL) {
	$db = &JFactory::getDbo();
	$query = "SELECT *,substring(anno,-4) FROM #__peliculas";

	if ($limites != NULL) {
	    $start = $this->getState('limitstart');
	    $limit = $this->getState('limit');
	    $query = $query . " " . $this->_getWhereString() . " " . $this->_getOrderString() . " LIMIT $start,$limit";
	}

	$db->setQuery($query);
	return $db->loadAssocList();
    }

    function obtenerPeliculaPorId($idPelicula) {
	$db = &JFactory::getDbo();
	$query = "SELECT * FROM #__peliculas WHERE id='{$idPelicula}'";
	$db->setQuery($query);
	return $db->loadAssoc();
    }

    function insertarPelicula($titulo, $anno, $tituloEsp, $sinopsis) {
	$db = &JFactory::getDbo();
	$query = "INSERT INTO #__peliculas SET titulo='{$titulo}',anno='{$anno}',tituloEspanol='{$tituloEsp}',resumenEspa='{$sinopsis}'";
	$db->setQuery($query);
	$db->query();
	$resultado = array();
	if ($db->getErrorNum()) {
	    return false;
	} else {
	    return true;
	}
    }

    function actualizarPelicula($idPelicula, $titulo, $anno, $tituloEsp, $sinopsis) {
	$db = &JFactory::getDbo();
	$query = "UPDATE #__peliculas SET titulo='{$titulo}',anno='{$anno}',tituloEspanol='{$tituloEsp}',resumenEspa='{$sinopsis}' WHERE id='{$idPelicula}'";
	$db->setQuery($query);
	$db->query();
	if ($db->getErrorNum()) {
	    return false;
	} else {
	    return true;
	}
    }

    function borrarPelicula($idPelicula) {
	$db = &JFactory::getDbo();
	$query = "DELETE FROM #__peliculas WHERE id='{$idPelicula}'";
	$db->setQuery($query);
	$db->query();
	if ($db->getErrorNum()) {
	    return false;
	} else {
	    return true;
	}
    }

    function obtenerDirector($idPelicula) {
	$db = &JFactory::getDbo();
	$query = "SELECT #__famosos.id AS id, #__famosos.nombre AS nombre FROM #__peliculas INNER JOIN #__famosos ON #__peliculas.idDirector=#__famosos.id WHERE #__peliculas.id='{$idPelicula}'";
	$db->setQuery($query);
	return $db->loadAssoc();
    }

    function añadirDirector($idPelicula, $idDirector) {
	$db = &JFactory::getDbo();
	$query = "UPDATE #__peliculas SET idDirector='{$idDirector}' WHERE id='{$idPelicula}'";
	$db->setQuery($query);
	$db->query();
	if ($db->getErrorNum()) {
	    return false;
	} else {
	    return true;
	}
    }

    function quitarDirector($idPelicula) {
	$db = &JFactory::getDbo();
	$query = "UPDATE #__peliculas SET idDirector=NULL WHERE id='{$idPelicula}'";
	$db->setQuery($query);
	$db->query();
	if ($db->getErrorNum()) {
	    return false;
	} else {
	    return true;
	}
    }

    function _getOrderString() {
	global $mainframe, $option;
	$filter_order = $mainframe->getUserStateFromRequest($option . '.peliculas.filter_order', 'filter_order', '', 'word');
	$filter_order_Dir = $mainframe->getUserStateFromRequest($option . '.peliculas.filter_order_Dir', 'filter_order_Dir', '', 'word');

	if ($filter_order != '') {
	    $orderby = ' ORDER BY ' . $filter_order . ' ' . $filter_order_Dir;
	} else {
	    $orderby = '';
	}
	return $orderby;
    }

    function _getWhereString() {
	global $mainframe, $option;
	$filter_state = $mainframe->getUserStateFromRequest($option . '.peliculas.filter_state', 'filter_state', '', 'word');
	$search = $mainframe->getUserStateFromRequest($option . '.peliculas.search', 'search', '', 'string');
	$search = $this->_db->getEscaped(trim(JString::strtolower($search)));
	if ($filter_state) {
	    if ($filter_state == 'P') {
		$where[] = 'g.published = 1';
	    } else if ($filter_state == 'U') {
		$where[] = 'g.published = 0';
	    }
	}
	$cadena = '';
	if ($search) {
	    $palabras = explode(" ", $search);
	    $cadena = " WHERE ";
	    foreach ($palabras as $palabra) {
		if ($cadena != " WHERE ") {
		    $cadena.=" AND ";
		}
		$cadena.=" (titulo like '%$palabra%' or tituloEspanol like '%$palabra%') ";
	    }
	}

	return $cadena;
    }

    //Devuelve SOLAMENTE los IDs de las peliculas que cumplan las condiciones
    function obtenerPeliculasPorCampos($campos, $limites = NULL) {
	$db = &JFactory::getDbo();
	$otraCondicion = false;

	$query = "SELECT DISTINCT #__peliculas.id AS id, #__peliculas.titulo AS titulo,
					#__peliculas.tituloEspanol AS tituloEspanol, #__peliculas.anno AS anno,
					#__peliculas.idDirector AS idDirector FROM #__peliculas
							LEFT JOIN #__famosos f1 ON #__peliculas.idDirector=f1.id 
							LEFT JOIN #__categoriaspeliculas ON #__peliculas.id=#__categoriaspeliculas.idPelicula 
							LEFT JOIN #__actorespelicula ON #__peliculas.id=#__actorespelicula.idPelicula 
							LEFT JOIN #__famosos f2 ON #__actorespelicula.idFamoso=f2.id WHERE ";

	if (isset($campos["titulo"])) {
	    $titulo = $campos["titulo"];
	    $query = $query . "#__peliculas.titulo LIKE '%$titulo%'";
	    $otraCondicion = true;
	}

	if (isset($campos["tituloEspanol"])) {
	    $tituloEspanol = $campos["tituloEspanol"];
	    if ($otraCondicion) {
		$query = $query . " AND ";
	    }
	    $query = $query . "#__peliculas.tituloEspanol LIKE '%$tituloEspanol%'";
	    $otraCondicion = true;
	}

	if (isset($campos["anno"])) {
	    $anno = $campos["anno"];
	    if ($otraCondicion) {
		$query = $query . " AND ";
	    }
	    $query = $query . "#__peliculas.anno LIKE '%$anno%'";
	    $otraCondicion = true;
	}

	if (isset($campos["nombreDirector"])) {
	    $nombreDirector = $campos["nombreDirector"];
	    if ($otraCondicion) {
		$query = $query . " AND ";
	    }
	    $query = $query . "f1.nombre LIKE '%$nombreDirector%'";
	    $otraCondicion = true;
	}

	if (isset($campos["idCategoria"])) {
	    $idCategoria = $campos["idCategoria"];
	    if ($otraCondicion) {
		$query = $query . " AND ";
	    }
	    $query = $query . "#__categoriaspeliculas.idCategoria='$idCategoria'";
	    $otraCondicion = true;
	}

	$actores = array();
	if (isset($campos["nombreActor1"])) {
	    $actores[] = $campos["nombreActor1"];
	}
	if (isset($campos["nombreActor2"])) {
	    $actores[] = $campos["nombreActor2"];
	}
	if (isset($campos["nombreActor3"])) {
	    $actores[] = $campos["nombreActor3"];
	}


	if (count($actores) > 0) {
	    if ($otraCondicion) {
		$query = $query . " AND ";
	    }
	    if (count($actores) == 1) {
		$actor1 = $actores[0];
		$query = $query . "f2.nombre LIKE '%$actor1%'";
	    } elseif (count($actores) == 2) {
		$actor1 = $actores[0];
		$actor2 = $actores[1];

		$query = $query . "f2.nombre LIKE '%$actor1%' AND #__peliculas.id IN (	SELECT idPelicula FROM #__actorespelicula 
							INNER JOIN #__famosos ON #__actorespelicula.idFamoso=#__famosos.id 
							WHERE #__famosos.nombre LIKE '%$actor2%')";
	    } elseif (count($actores) == 3) {
		$actor1 = $actores[0];
		$actor2 = $actores[1];
		$actor3 = $actores[2];

		$query = $query . "f2.nombre LIKE '%$actor1%' AND #__peliculas.id IN (	SELECT idPelicula FROM #__actorespelicula 
							INNER JOIN #__famosos ON #__actorespelicula.idFamoso=#__famosos.id 
							WHERE #__famosos.nombre LIKE '%$actor2%' AND idPelicula IN (
								SELECT idPelicula FROM #__actorespelicula 
								INNER JOIN #__famosos ON #__actorespelicula.idFamoso=#__famosos.id 
								WHERE #__famosos.nombre LIKE '%$actor3%'))";
	    }
	}

	if ($limites != NULL) {
	    $start = $this->getState('limitstart');
	    $limit = $this->getState('limit');
	    $query = $query . " " . $this->_getWhereString() . " " . $this->_getOrderString() . " LIMIT $start,$limit";
	}

	$db->setQuery($query);
	$resultado = $db->loadAssocList();


	$identificadores = array();
	if (isset($resultado)) {
	    foreach ($resultado as $res) {
		$identificadores[] = $res["id"];
	    }

	    return $identificadores;
	} else {
	    return array();
	}
    }

}

?>
