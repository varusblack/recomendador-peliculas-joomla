<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class PeliculasModelActoresPelicula extends JModel {

    function insertar($idFamoso, $idPelicula) {
        $db = &JFactory::getDbo();
        $query = "INSERT INTO #__actorespelicula SET idFamoso='{$idFamoso}', idPelicula='{$idPelicula}'";
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            return false;
        } else {
            return true;
        }
    }

    function borrarPorPelicula($idPelicula) {
        $db = &JFactory::getDbo();
        $query = "DELETE FROM #__actorespelicula WHERE idPelicula='{$idPelicula}'";
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            return false;
        } else {
            return true;
        }
    }

    function borrarPorFamoso($idFamoso) {
        $db = &JFactory::getDbo();
        $query = "DELETE FROM #__actorespelicula WHERE idFamoso='{$idFamoso}'";
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            return false;
        } else {
            return true;
        }
    }

    function obtenerActoresDePelicula($idPelicula) {
        $db = &JFactory::getDbo();
        $query = "SELECT #__famosos.id AS id, #__famosos.nombre AS nombre FROM #__actorespelicula INNER JOIN #__famosos ON #__actorespelicula.idFamoso=#__famosos.id WHERE #__actorespelicula.idPelicula='{$idPelicula}'";
        $db->setQuery($query);
        return $db->loadAssocList();
    }

}

?>