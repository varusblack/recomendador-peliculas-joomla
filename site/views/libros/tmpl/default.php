<?php
    defined('_JEXEC') or die('Restricted access');
    $link_insertar=JRoute::_('index.php?option=com_libros&task=leelibro');
    
?>
<h1 style="text-align: center;">
    <?php echo $this->titulo;?>
</h1>

<a href='<?php echo $link_insertar;?>'>Nuevo libro</a>