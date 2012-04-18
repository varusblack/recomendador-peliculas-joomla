<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class PeliculasViewCategorias extends JView {

    function display($tpl = null) {
        JToolBarHelper::title('Categorías de películas');
        JToolBarHelper::addNew();
        JToolBarHelper::deleteList();
        JToolBarHelper::editList();
        parent::display();
    }

    function edit() {
        JToolBarHelper::title('Editar categoría');
        JToolBarHelper::save();
        JToolBarHelper::cancel();

        parent::display('edit');
    }

    function add() {
        JToolBarHelper::title('Añadir categoria');
        JToolBarHelper::save();
        JToolBarHelper::cancel();

        parent::display('add');
    }
    
    function remove() {
        JToolBarHelper::title('Borrar categorias');
        JToolBarHelper::save();
        JToolBarHelper::cancel();

        parent::display('remove');
    }

}

?>
