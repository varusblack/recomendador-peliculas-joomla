<?php 

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class FamososModelFamosos extends JModel {
	
	function obtenerFamosoPorId ($idFamoso) {
		$db = &JFactory::getDbo();
		$query = "SELECT * FROM #__famoso WHERE id='{$idFamoso}'";
		$db->setQuery($query);
		return $db->loadAssoc();
	}
	
	function obtenerTodosLosFamosos (){
		$db = &JFactory::getDbo();
		$query = "SELECT * FROM #__famosos";
		$db->setQuery($query);
		return $db->loadAssocList();
	}
	
	function insertarFamoso ($nombre) {
		$db = &JFactory::getDbo();
		$query = "INSERT INTO #__famoso SET nombre='{$nombre}'";
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
		$query = "UPDATE #__famoso SET nombre='{$nombre}' WHERE id='{$idFamoso}'";
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
		$query = "DELETE FROM #__famoso WHERE id='{$nombre}'";
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