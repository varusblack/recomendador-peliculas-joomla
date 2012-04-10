<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class LibrosModelLibros extends JModel {

    function dameUnTitulo() {
        $db = &JFactory::getDbo();
        $query = "SELECT titulo FROM #__libros ORDER BY RAND() LIMIT 1";
        $db->setQuery($query);
        return $db->loadResult();
    }

    function dameTodosLosLibros() {
        $db = &JFactory::getDbo();
        $query = "SELECT * FROM #__libros";
        $db->setQuery($query);
        return $db->loadAssocList();
    }

    function dameLibro($id) {
        $db = &JFactory::getDbo();
        $query = "SELECT * FROM #__libros where id='{$id}'";
        $db->setQuery($query);
        return $db->loadAssoc();
    }

    function eliminaLibro($id) {
        $db = &JFactory::getDbo();
        $query = "DELETE FROM #__libros where id='{$id}'";
        $db->setQuery($query);
        $db->query();
        if ($db->getErrorNum()) {
            return false;
        } else {
            return true;
        }
    }

    function actualizaLibro($id, $titulo) {
        $db = &JFactory::getDbo();
        $query = "UPDATE #__libros set titulo='{$titulo}' where id='{$id}'";
        $db->setQuery($query);
        $db->query();
        if ($db->getErrorNum()) {
            return false;
        } else {
            return true;
        }
    }

    function grabaLibro($titulo) {
        $db = &JFactory::getDbo();
        $query = "INSERT INTO #__libros SET titulo='{$titulo}'";
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
