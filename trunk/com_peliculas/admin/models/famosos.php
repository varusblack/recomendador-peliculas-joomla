<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class PeliculasModelFamosos extends JModel {

    var $_total;
    var $_pagination;

    function __construct() {
        parent::__construct();
        global $mainframe, $option;
        $mainframe = JFactory::getApplication();
        $limit = $mainframe->getUserStateFromRequest($option.'.famosos.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
        $limitstart = JRequest::getVar('limitstart', 0, '', 'int');
        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
    }

    function obtenerNumeroDeFamosos() {
        $db = &JFactory::getDbo();
        $query = "SELECT count(*) as cuenta FROM #__famosos ".$this->_getWhereString();
        $db->setQuery($query);
        $resultado = $db->loadAssocList();

        return $resultado[0]["cuenta"];
    }

    function getPagination() {
        if (empty($this->_pagination)) {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination($this->obtenerNumeroDeFamosos(), $this->getState('limitstart'), $this->getState('limit'));
        }
        return $this->_pagination;
    }

    function obtenerFamososLimites() {
        $start = $this->getState('limitstart');
        $limit = $this->getState('limit');

        $db = &JFactory::getDbo();
        $query = "SELECT * FROM #__famosos". $this->_getWhereString() . " " . $this->_getOrderString() . " LIMIT $start,$limit";
        $db->setQuery($query);
        return $db->loadAssocList();
    }

    function obtenerTodosLosFamosos() {
        $db = &JFactory::getDbo();
        $query = "SELECT * FROM #__famosos";
        $db->setQuery($query);
        return $db->loadAssocList();
    }

    function obtenerFamosoPorId($idFamoso) {
        $db = &JFactory::getDbo();
        $query = "SELECT * FROM #__famosos WHERE id='{$idFamoso}'";
        $db->setQuery($query);
        return $db->loadAssoc();
    }

    function insertarFamoso($nombre) {
        $db = &JFactory::getDbo();
        $query = "INSERT INTO #__famosos SET nombre='{$nombre}'";
        $db->setQuery($query);
        $db->query();
        if ($db->getErrorNum()) {
            return false;
        } else {
            return true;
        }
    }

    function actualizarFamoso($idFamoso, $nombre) {
        $db = &JFactory::getDbo();
        $query = "UPDATE #__famosos SET nombre='{$nombre}' WHERE id='{$idFamoso}'";
        $db->setQuery($query);
        $db->query();
        if ($db->getErrorNum()) {
            return false;
        } else {
            return true;
        }
    }

    function borrarFamoso($idFamoso) {
        $db = &JFactory::getDbo();
        $query = "DELETE FROM #__famosos WHERE id='{$idFamoso}'";
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
        $filter_order = $mainframe->getUserStateFromRequest($option . '.famosos.filter_order', 'filter_order', '', 'word');
        $filter_order_Dir = $mainframe->getUserStateFromRequest($option . '.famosos.filter_order_Dir', 'filter_order_Dir', '', 'word');

        if ($filter_order != '') {
            $orderby = ' ORDER BY ' . $filter_order . ' ' . $filter_order_Dir;
        } else {
            $orderby = '';
        }
        return $orderby;
    }

    function _getWhereString() {
        global $mainframe, $option;
        $filter_state = $mainframe->getUserStateFromRequest($option . '.famosos.filter_state', 'filter_state', '', 'word');
        $search = $mainframe->getUserStateFromRequest($option . '.famosos.search', 'search', '', 'string');
        $search = $this->_db->getEscaped(trim(JString::strtolower($search)));
        if ($filter_state) {
            if ($filter_state == 'P') {
                $where[] = 'g.published = 1';
            } else if ($filter_state == 'U') {
                $where[] = 'g.published = 0';
            }
        }
        $cadena='';
        if ($search) {
            $palabras = explode(" ", $search);
            $cadena = " WHERE ";
            foreach ($palabras as $palabra) {
                if ($cadena != " WHERE ") {
                    $cadena.=" AND ";
                } 
                $cadena.=" nombre like '%$palabra%'";
            }
        }

        return $cadena;
    }

}

?>