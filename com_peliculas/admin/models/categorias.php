<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class PeliculasModelCategorias extends JModel {

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

    function obtenerTodasLasCategorias() {
        $db = &JFactory::getDbo();
        $query = "SELECT * FROM #__categorias";
        $db->setQuery($query);

        return $db->loadAssocList();
    }

    function obtenerCategoriasLimites() {
        $start = $this->getState('limitstart');
        $limit = $this->getState('limit');

        $db = &JFactory::getDbo();
        $query = "SELECT * FROM #__categorias ". $this->_getWhereString() . " " . $this->_getOrderString() . " LIMIT $start,$limit";

        $db->setQuery($query);

        return $db->loadAssocList();
    }

    function obtenerNumeroCategorias() {
        $db = &JFactory::getDbo();
        $query = "SELECT count(*) as cuenta FROM #__categorias";
        $db->setQuery($query);
        $resultado = $db->loadAssocList();

        return $resultado[0]["cuenta"];
    }

    function getPagination() {
        // Load the content if it doesn't already exist
        if (empty($this->_pagination)) {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination($this->obtenerNumeroCategorias(), $this->getState('limitstart'), $this->getState('limit'));
        }
        return $this->_pagination;
    }

    function dameCategoria($id) {
        $db = &JFactory::getDbo();
        $query = "SELECT * FROM #__categorias WHERE id='$id'";
        $db->setQuery($query);

        return $db->loadAssoc();
    }

    function addCategoria($nombre) {
        $db = &JFactory::getDbo();
        $query = "INSERT INTO #__categorias SET categoria='$nombre'";
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            return false;
        } else {
            return true;
        }
    }

    function updateCategoria($nombre, $id) {
        $db = &JFactory::getDbo();
        $query = "UPDATE #__categorias SET categoria='$nombre' WHERE id=$id";
        $db->setQuery($query);
        $db->query();
        if ($db->getErrorNum()) {
            return false;
        } else {
            return true;
        }
    }
    
    function deleteCategoria($id){
        $db = &JFactory::getDbo();
        $query = "DELETE FROM #__categorias WHERE id=$id";
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

        if ($search) {
            $palabras = explode(" ", $search);
            $cadena = " WHERE ";
            foreach ($palabras as $palabra) {
                if ($cadena != " WHERE ") {
                    $cadena.=" AND ";
                } 
                $cadena.=" categoria like '%$palabra%'";
            }
        }

        return $cadena;
    }

}

?>