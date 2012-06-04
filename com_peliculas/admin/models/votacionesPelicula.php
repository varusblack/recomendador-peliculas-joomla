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
        $query = "SELECT #__peliculas.id AS id, #__peliculas.titulo AS titulo, #__peliculas.anno AS anno, 
        			#__peliculas.tituloEspanol AS tituloEspanol,#__famosos.nombre AS director, #__votos.voto AS puntuacion, 
        			#__votos.timestamp AS timestamp 
        			FROM #__votos INNER JOIN #__peliculas ON #__votos.idPelicula=#__peliculas.id 
        			INNER JOIN #__famosos ON #__peliculas.idDirector=#__famosos.id 
        			WHERE #__votos.idUsuario='{$idUsuario}' AND #__votos.idPelicula='{$idPelicula}'";
        $db->setQuery($query);
        return $db->loadAssoc();
    }

    function obtenerPeliculasVotadasPorUsuario($idUsuario, $limites = NULL) {
        $db = &JFactory::getDbo();
// 		Devuelve: id,titulo,anno,tituloEspanol,director,puntuacion,timestamp
        $query = "SELECT #__peliculas.id AS id, #__peliculas.titulo AS titulo, #__peliculas.anno AS anno, 
        #__peliculas.tituloEspanol AS tituloEspanol,#__famosos.nombre AS director, #__votos.voto AS puntuacion, 
        #__votos.timestamp AS timestamp 
        FROM #__votos INNER JOIN #__peliculas ON #__votos.idPelicula=#__peliculas.id 
        INNER JOIN #__famosos ON #__peliculas.idDirector=#__famosos.id 
        WHERE #__votos.idUsuario='{$idUsuario}'";

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
        $query = "SELECT #__peliculas.id AS id, #__peliculas.titulo AS titulo, #__peliculas.anno AS anno, 
        #__peliculas.tituloEspanol AS tituloEspanol, #__famosos.nombre AS director 
        FROM #__peliculas INNER JOIN #__famosos ON #__famosos.id=#__peliculas.idDirector 
        WHERE #__peliculas.id NOT IN (SELECT idPelicula FROM #__votos WHERE idUsuario='{$idUsuario}') ORDER BY RAND() LIMIT 10";

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

    function obtenerVotoPorUsuarioYPelicula($idUsuario, $idPelicula) {
        $db = &JFactory::getDbo();
        $query = "SELECT * FROM #__votos WHERE idUsuario='{$idUsuario}' and idPelicula=$idPelicula";

        $db->setQuery($query);
        return $db->loadAssoc()->voto;
    }

    function obtenerUsuariosQueHanVotadoUnaPelicula($idPelicula) {
        $db = &JFactory::getDbo();

        $query = "SELECT * FROM #__votos WHERE idPelicula='{$idPelicula}'";

        $db->setQuery($query);
        return $db->loadAssocList();
    }

    function obtenerPeliculasNoVistasDelVecino($idUsuario, $idVecino) {
        $db = &JFactory::getDbo();

        $query = "select * from #__votos where idUsuario='{$idVecino}' and idPelicula not in (select idPelicula from #__votos where idUsuario='{$idUsuario}')";

        $db->setQuery($query);
        return $db->loadAssocList();
    }

    function calculaMedia($idUsuario) {
        $db = &JFactory::getDbo();
        $query = "SELECT avg(voto) as media FROM #__votos WHERE idUsuario='{$idUsuario}'";

        $db->setQuery($query);
        $res = $db->loadAssoc();
        return $res["media"];
    }

}

?>
