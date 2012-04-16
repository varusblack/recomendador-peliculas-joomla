<?php
    defined('_JEXEC') or die('Restricted access');
    
    jimport('joomla.application.component.view');
    
    class FamososViewFamosos extends JView{
        function display($tpl=null){
            parent::display();
        }
        
        function verFamoso(){
            parent::display('verfamoso');
        }
    }
    
    

?>