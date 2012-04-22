<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class PeliculasModelPeliculasCategorias extends JModel {

    function add($idPelicula,$idCategoria){
        $db = &JFactory::getDbo();
        $query = "INSERT INTO #__categoriasPeliculas SET idPelicula='$idPelicula',idCategoria='$idCategoria'";
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            return false;
        } else {
            return true;
        }
    }
    
    function deleteByCategoria($idCategoria){
        $db = &JFactory::getDbo();
        $query = "DELETE FROM #__categoriasPeliculas WHERE idCategoria='$idCategoria'";
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            return false;
        } else {
            return true;
        }
    }
    
    function deleteByPelicula($idPelicula){
        $db = &JFactory::getDbo();
        $query = "DELETE FROM #__categoriasPeliculas WHERE idPelicula='$idPelicula'";
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            return false;
        } else {
            return true;
        }
    }
    
    function deleteByPeliculaCategoria($idPelicula,$idCategoria){
        $db = &JFactory::getDbo();
        $query = "DELETE FROM #__categoriasPeliculas WHERE idPelicula='$idPelicula' and idCategoria='$idCategoria'";
        $db->setQuery($query);
        $db->query();

        if ($db->getErrorNum()) {
            return false;
        } else {
            return true;
        }
    }
    
    function getByPelicula($idPelicula){
        $db = &JFactory::getDbo();
        $query = "SELECT * FROM #__categoriasPeliculas WHERE idPelicula='$idPelicula'";
        $db->setQuery($query);

        return $db->loadAssocList();
    }
    
    function getByCategoria($idCategoria){
        $db = &JFactory::getDbo();
        $query = "SELECT * FROM #__categoriasPeliculas WHERE idCategoria='$idCategoria'";
        $db->setQuery($query);

        return $db->loadAssocList();
    }
	
	function obtenerCategoriasDePeliculas ($idPelicula) {
		$db = &JFactory::getDbo();
		$query = "SELECT #__categorias.id AS id, #__categorias.categoria AS categoria FROM #__categoriaspeliculas INNER JOIN #__categorias ON #__categoriaspeliculas.idCategoria=#__categorias.id WHERE #__categoriaspeliculas.idPelicula='{$idPelicula}'";
		$db->setQuery($query);
		return $db->loadAssocList();
	}
}