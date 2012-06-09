<?php
defined('_JEXEC') or die('Restricted access');

$path = '/media/com_peliculas/';
$filename ='ajaxVotacion.js';
JHTML::script($filename, $path);
JHTML::stylesheet('peliculas.css', '/media/com_peliculas/');
?>
<form name="userForm" method="post" action="index.php">

    <?php
    echo $this->texto;
	?>

    <input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="task" value="busquedaAvanzada" />
</form>