<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class PeliculasModelVotacionesPelicula extends JModel {

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

    function getPagination($resultados) {
        if (empty($this->_pagination)) {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination(count($resultados), $this->getState('limitstart'), $this->getState('limit'));
        }
        return $this->_pagination;
    }

    function votarPelicula($idUsuario, $idPelicula, $puntuacion) {
        $timestamp = time();
        $db = &JFactory::getDbo();
        $query = "INSERT INTO #__votos SET idUsuario='{$idUsuario}', idPelicula='{$idPelicula}', voto='{$puntuacion}', timestamp='{$timestamp}'";
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            return false;
        } else {
            return true;
        }
    }

    function actualizarVoto($idUsuario, $idPelicula, $puntuacion) {
        $timestamp = time();
        $db = &JFactory::getDbo();
        $query = "UPDATE #__votos SET voto='{$puntuacion}', timestamp='{$timestamp}' WHERE idUsuario='{$idUsuario}' AND idPelicula='{$idPelicula}'";
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            return false;
        } else {
            return true;
        }
    }

    function borrarVotosPorPelicula($idPelicula) {
        $db = &JFactory::getDbo();
        $query = "DELETE FROM #__votos WHERE idPelicula='{$idPelicula}'";
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            return false;
        } else {
            return true;
        }
    }

    function borrarVotosPorUsuario($idUsuario) {
        $db = &JFactory::getDbo();
        $query = "DELETE FROM #__votos WHERE idUsuario='{$idUsuario}'";
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            return false;
        } else {
            return true;
        }
    }

    function obtenerUnicaPeliculaVotadaPorUsuario($idUsuario, $idPelicula) {
        $db = &JFactory::getDbo();
// 		Devuelve: id,titulo,anno,tituloEspanol,director,puntuacion,timestamp
        $query = "SELECT #__peliculas.id AS id, #__peliculas.titulo AS titulo, #__peliculas.anno AS anno, #__peliculas.tituloEspanol AS tituloEspanol,#__famosos.nombre AS director, #__votos.voto AS puntuacion, #__votos.timestamp AS timestamp FROM #__votos INNER JOIN #__peliculas ON #__votos.idPelicula=#__peliculas.id LEFT JOIN #__famosos ON #__peliculas.idDirector=#__famosos.id WHERE #__votos.idUsuario='{$idUsuario}' AND #__votos.idPelicula='{$idPelicula}'";
        $db->setQuery($query);
        return $db->loadAssoc();
    }

    function obtenerPeliculasVotadasPorUsuario($idUsuario, $limites = NULL) {
        $db = &JFactory::getDbo();
// 		Devuelve: id,titulo,anno,tituloEspanol,director,puntuacion,timestamp
        $query = "SELECT #__peliculas.id AS id, #__peliculas.titulo AS titulo, #__peliculas.anno AS anno, #__peliculas.tituloEspanol AS tituloEspanol,#__famosos.nombre AS director, #__votos.voto AS puntuacion, #__votos.timestamp AS timestamp FROM #__votos INNER JOIN #__peliculas ON #__votos.idPelicula=#__peliculas.id LEFT JOIN #__famosos ON #__peliculas.idDirector=#__famosos.id WHERE #__votos.idUsuario='{$idUsuario}'";

        if ($limites != NULL) {
            $start = $this->getState('limitstart');
            $limit = $this->getState('limit');
            $query = $query . " " . $this->_getWhereString() . " " . $this->_getOrderString() . " LIMIT $start,$limit";
        }

        $db->setQuery($query);
        return $db->loadAssocList();
    }

    function obtenerPeliculasAleatoriasNoVotadasPorUsuario($idUsuario) {
        $db = &JFactory::getDbo();
// 		Devuelve: id,titulo,anno,tituloEspanol,director
        $query = "SELECT #__peliculas.id AS id, #__peliculas.titulo AS titulo, #__peliculas.anno AS anno, #__peliculas.tituloEspanol AS tituloEspanol, #__famosos.nombre AS director FROM #__peliculas LEFT JOIN #__famosos ON #__famosos.id=#__peliculas.idDirector WHERE #__peliculas.id NOT IN (SELECT idPelicula FROM #__votos WHERE idUsuario='{$idUsuario}') ORDER BY RAND() LIMIT 10";

        $db->setQuery($query);
        return $db->loadAssocList();
    }

    function obtenerVotosUsuario($idUsuario) {
        $db = &JFactory::getDbo();
// 		Devuelve: id,titulo,anno,tituloEspanol,director,puntuacion,timestamp
        $query = "SELECT * FROM #__votos WHERE idUsuario='{$idUsuario}'";

        $db->setQuery($query);
        return $db->loadAssocList();
    }

}

?>