<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class LibrosViewLibros extends JView {

    function display($tpl=null) {
        JToolBarHelper::title('Libros');
        JToolBarHelper::addNew();
        JToolBarHelper::deleteList();
        JToolBarHelper::editList();

        parent::display();
    }

    function edit() {
        JToolBarHelper::title('Editar libro');
        JToolBarHelper::save();
        JToolBarHelper::cancel();

        parent::display('editor');
    }

    function add() {
        JToolBarHelper::title('Añadir libro');
        JToolBarHelper::save();
        JToolBarHelper::cancel();

        parent::display('add');
    }

}

?>
