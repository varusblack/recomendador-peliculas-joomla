<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class PeliculasViewFilms extends JView{
	
	function display($tpl = null){
		JToolBarHelper::title('Películas');
        JToolBarHelper::addNew();
        JToolBarHelper::deleteList();
        JToolBarHelper::editList();

        parent::display();
	}
	
	function edit(){
		JToolBarHelper::title('Editar datos de la película');
		JToolBarHelper::custom('insertarDirector','','','Insertar director',false,false);
		JToolBarHelper::custom('insertarActor','','','Insertar actor',false,false);
		JToolBarHelper::custom('insertarCategoria','','','Insertar categoria',false,false);
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
        JToolBarHelper::save('processRemove');
        JToolBarHelper::cancel();

        parent::display('remove');
    }
	
	function insertarDirector(){
		JToolBarHelper::title('Insertar director');
        JToolBarHelper::save('grabarDirector');
        JToolBarHelper::cancel();

        parent::display('insertarDirector');
	}

	function insertarActor() {
		JToolBarHelper::title('Insertar actor');
        JToolBarHelper::save('grabarActor');
        JToolBarHelper::cancel();

        parent::display('insertarActor');
	}

	function insertarCategoria() {
		JToolBarHelper::title('Insertar categoria');
        JToolBarHelper::save('grabarCategoria');
        JToolBarHelper::cancel();

        parent::display('insertarCategoria');
	}
}


?>