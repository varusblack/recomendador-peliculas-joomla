<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class PeliculasViewFamosos extends JView{
	
	function display($tpl = null){
		JToolBarHelper::title('Famosos');
        JToolBarHelper::addNew();
        JToolBarHelper::deleteList();
        JToolBarHelper::editList();

        parent::display();
	}
	
	function edit(){
		JToolBarHelper::title('Editar nombre de famoso');
        JToolBarHelper::save();
        JToolBarHelper::cancel();

        parent::display('edit');
	}
	
	function add(){
		JToolBarHelper::title('Insertar famoso');
        JToolBarHelper::save();
        JToolBarHelper::cancel();
		
		parent::display('add');
	}
	
	function remove() {
        JToolBarHelper::title('Borrar famoso');
        JToolBarHelper::save();
        JToolBarHelper::cancel();

        parent::display('remove');
    }
	
}


?>