<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class PeliculasModelCategorias extends JModel {

    var $_total;
    var $_pagination;

    function __construct() {
        parent::__construct();
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
        $start = $this->getState('limitStart');
        $limit = $this->getState('limit');
        if ($start == '') {
            $start = 0;
        }
        $db = &JFactory::getDbo();
        $query = "SELECT * FROM #__categorias LIMIT $start,$limit";

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

}

?>