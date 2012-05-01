<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class PeliculasModelUsuarios extends JModel {

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

    function obtenerTodasLosUsuarios() {
        $db = &JFactory::getDbo();
        $query = "SELECT * FROM #__users WHERE usertype='Registered'";
        $db->setQuery($query);

        return $db->loadAssocList();
    }

    function obtenerUsuariosLimites() {
        $start = $this->getState('limitstart');
        $limit = $this->getState('limit');

        $db = &JFactory::getDbo();
        $query = "SELECT * FROM #__users WHERE usertype='Registered' LIMIT $start,$limit";

        $db->setQuery($query);

        return $db->loadAssocList();
    }

    function obtenerNumeroUsuarios() {
        $db = &JFactory::getDbo();
        $query = "SELECT count(*) as cuenta FROM #__users";
        $db->setQuery($query);
        $resultado = $db->loadAssocList();

        return $resultado[0]["cuenta"];
    }

    function getPagination() {
        // Load the content if it doesn't already exist
        if (empty($this->_pagination)) {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination($this->obtenerNumeroUsuarios(), $this->getState('limitstart'), $this->getState('limit'));
        }
        return $this->_pagination;
    }

    function dameUsuario($id) {
        $db = &JFactory::getDbo();
        $query = "SELECT * FROM #__users WHERE id='$id'";
        $db->setQuery($query);

        return $db->loadAssoc();
    }

    

}

?>