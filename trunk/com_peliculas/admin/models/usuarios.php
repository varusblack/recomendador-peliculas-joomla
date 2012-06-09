<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class PeliculasModelUsuarios extends JModel {

    var $_total;
    var $_pagination;

    function __construct() {
        parent::__construct();
    }
    function dameUsuario($id) {
        $db = &JFactory::getDbo();
        $query = "SELECT * FROM #__users WHERE id='$id'";
        $db->setQuery($query);

        return $db->loadAssoc();
    }

    function calculaLongitudVector() {
        $db = &JFactory::getDbo();
        $query = "UPDATE #__users SET vector = ( SELECT SQRT( SUM( voto * voto ) ) 
                FROM #__votos
                WHERE idUsuario = #__users.id )";
        $db->setQuery($query);
        $db->query();
    }

}

?>