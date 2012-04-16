<?php
    defined('_JEXEC') or die('Restricted access');
    $link_insertar=JRoute::_('index.php?option=com_famosos&task=verfamoso');
    
?>
<h1 style="text-align: center;">
    <?php echo $this->nombre;?>
</h1>

<a href='<?php echo $link_insertar;?>'>Nuevo famoso</a>