<?php
    defined('_JEXEC') or die('Restricted access');
    
    jimport('joomla.application.component.view');
    
    class LibrosViewLibros extends JView{
        function display($tpl=null){
            parent::display();
        }
        
        function leeLibro(){
            parent::display('leelibro');
        }
    }
    
    

?>
