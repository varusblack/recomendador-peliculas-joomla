<?php
defined('_JEXEC') or die('Restricted access');


$path = '/media/com_peliculas/';
$filename ='ajaxVotacion.js';
JHTML::script($filename, $path);
JHTML::stylesheet('peliculas.css', '/media/com_peliculas/');
?>
<form class="user" action="index.php" method="post" name="userform">
<?php
	if(strlen($this->texto) == 0){
		echo "No hay películas para votar.";
	}else{ 
			echo $this->texto;
		?>
		
	<div class="centrado">
		<button type="button" title="Mas Peliculas" onclick="location='index.php?option=com_peliculas&task=votar'">Más películas</button>
	</div>
	<?php
	}
	?>
	
</form>
