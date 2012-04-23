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
        $limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
        $limitstart = JRequest::getVar('limitstart', 0, '', 'int');
        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
    }

    function getPagination() {
        if (empty($this->_pagination)) {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination($this->obtenerNumeroDePeliculas(), $this->getState('limitstart'), $this->getState('limit'));
        }
        return $this->_pagination;
    }

    function obtenerPeliculasLimites() {
        $start = $this->getState('limitstart');
        $limit = $this->getState('limit');

        $db = &JFactory::getDbo();
        $query = "SELECT * FROM #__peliculas LIMIT $start,$limit";
        $db->setQuery($query);
        return $db->loadAssocList();
    }

    function obtenerNumeroDePeliculas() {
        $db = &JFactory::getDbo();
        $query = "SELECT count(*) as cuenta FROM #__peliculas";
        $db->setQuery($query);
        $resultado = $db->loadAssocList();

        return $resultado[0]["cuenta"];
    }

    function obtenerTodasLasPeliculas() {
        $db = &JFactory::getDbo();
        $query = "SELECT * FROM #__peliculas";
        $db->setQuery($query);
        return $db->loadAssocList();
    }

    function obtenerPeliculaPorId($idPelicula) {
        $db = &JFactory::getDbo();
        $query = "SELECT * FROM #__peliculas WHERE id='{$idPelicula}'";
        $db->setQuery($query);
        return $db->loadAssoc();
    }

    function insertarPelicula($titulo, $anno, $videoRelease, $tituloEsp) {
        $db = &JFactory::getDbo();
        $query = "INSERT INTO #__peliculas SET titulo='{$titulo}',anno='{$anno}',videoRelease='{$videoRelease}',tituloEspanol='{$tituloEsp}'";
        $db->setQuery($query);
        $db->query();
        if ($db->getErrorNum()) {
            return false;
        } else {
            return true;
        }
    }

    function actualizarPelicula($idPelicula, $titulo, $anno, $videoRelease, $tituloEsp) {
        $db = &JFactory::getDbo();
        $query = "UPDATE #__peliculas SET titulo='{$titulo}',anno='{$anno}',videoRelease='{$videoRelease}',tituloEspanol='{$tituloEsp}' WHERE id='{$idPelicula}'";
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
	
	function añadirDirector($idpelicula, $idDirector){
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

}

?>