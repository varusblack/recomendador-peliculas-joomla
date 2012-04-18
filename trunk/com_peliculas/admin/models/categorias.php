<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class PeliculasModelCategorias extends JModel {

    function obtenerTodasLasCategorias() {
        $db = &JFactory::getDbo();
        $query = "SELECT * FROM #__categorias";
        $db->setQuery($query);
        
        return $db->loadAssocList();
    }
    
    function dameCategoria($id) {
        $db = &JFactory::getDbo();
        $query = "SELECT * FROM #__categorias WHERE id='$id'";
        $db->setQuery($query);
        
        return $db->loadAssoc();
    }
    
    function addCategoria($nombre){
        $db = &JFactory::getDbo();
        $query = "INSERT INTO #__categorias SET categoria='$nombre'";
        $db->setQuery($query);
        $db->query();
        
        if($db->getErrorNum()){
            return false;
        }else{
            return true;
        }
    }
    
    function updateCategoria($nombre,$id){
        $db = &JFactory::getDbo();
        $query = "UPDATE #__categorias SET categoria='$nombre' WHERE id=$id";
        $db->setQuery($query);
        $db->query();
        if($db->getErrorNum()){
            return false;
        }else{
            return true;
        }
    }

}

?>