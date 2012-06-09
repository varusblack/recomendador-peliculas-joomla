<?php
defined('_JEXEC') or die('Restricted access');

$path = '/media/com_peliculas/';
$filename = 'ajaxVotacion.js';
JHTML::script($filename, $path);
JHTML::stylesheet('peliculas.css', '/media/com_peliculas/');
?>
<form name="userForm" method="post" action="index.php">

	<?php 
		$pagina = $this->texto;
		echo $pagina;
	?>
	
	<input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="task" value="vervotadas" />
    <input type="hidden" name="filter_order" value="<?php echo $this->filter_order; ?>" />
    <input type="hidden" name="filter_order_Dir" value="" />
    <input type="hidden" name="filter_state" value="<?php echo $this->filter_state; ?>" />
</form>