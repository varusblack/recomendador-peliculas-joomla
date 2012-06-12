<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class PeliculasViewFilms extends JView {

    function mostrar() {
	parent::display('mostrarImagen');
    }

}

?>