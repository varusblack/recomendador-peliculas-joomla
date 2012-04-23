<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class PeliculasViewFilms extends JView{
	
	function display($tpl = null){
		JToolBarHelper::title('Películas');
        JToolBarHelper::addNew();
		JToolBarHelper::custom('insertarDirector','','','Insertar director',false,false);
        JToolBarHelper::deleteList();
        JToolBarHelper::editList();

        parent::display();
	}
	
	function edit(){
		JToolBarHelper::title('Editar datos de la película');
        JToolBarHelper::save();
        JToolBarHelper::cancel();

        parent::display('edit');
	}
	
	function add(){
		JToolBarHelper::title('Insertar película');
        JToolBarHelper::save();
        JToolBarHelper::cancel();
		
		parent::display('add');
	}
	
	function remove() {
        JToolBarHelper::title('Borrar película');
        JToolBarHelper::save();
        JToolBarHelper::cancel();

        parent::display('remove');
    }
	
	function custom(){
		JToolBarHelper::title('Insertar actores');
        JToolBarHelper::save();
        JToolBarHelper::cancel();

        parent::display('remove');
	}
}


?>