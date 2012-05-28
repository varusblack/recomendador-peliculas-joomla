<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class PeliculasViewUsuarios extends JView {

    function display($tpl = null) {
        JToolBarHelper::title('Usuarios');
        JToolBarHelper::custom('calculaVecindario','','','Recalcular Vecindario',false,false);
        parent::display();
    }
}

?>
