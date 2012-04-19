<?php 

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class PeliculasModelFamosos extends JModel {
	
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
	
	function obtenerNumeroDeFamosos (){
		$db = &JFactory::getDbo();
        $query = "SELECT count(*) as cuenta FROM #__famosos";
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
		$start = $this->getState('limitStart');
        $limit = $this->getState('limit');
        if ($start == '') {
            $start = 0;
        }
        $db = &JFactory::getDbo();
        $query = "SELECT * FROM #__famosos LIMIT $start,$limit";
        $db->setQuery($query);
        return $db->loadAssocList();
	}
	
	function obtenerTodosLosFamosos (){
		$db = &JFactory::getDbo();
		$query = "SELECT * FROM #__famosos";
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	
	function obtenerFamosoPorId ($idFamoso) {
		$db = &JFactory::getDbo();
		$query = "SELECT * FROM #__famosos WHERE id='{$idFamoso}'";
		$db->setQuery($query);
		return $db->loadAssoc();
	}
	
	function insertarFamoso ($nombre) {
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
	
	function actualizarFamoso ($idFamoso, $nombre) {
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
	
	function borrarFamoso ($idFamoso) {
		$db = &JFactory::getDbo();
		$query = "DELETE FROM #__famosos WHERE id='{$nombre}'";
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