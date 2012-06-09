<?php
defined('_JEXEC') or die('Restricted access');

$filename = 'table-ordering.js';
$path = '/media/system/js/';
JHTML::script($filename, $path);
$filename = 'ajaxVotacion.js';
JHTML::script($filename, $path);
JHTML::stylesheet('peliculas.css', '/media/com_peliculas/');
?>
<form name="userForm" method="post" action="index.php">

	<table>
		<thead>
			<tr>
				<th class="title"><?php echo JHTML::_('grid.sort', 'Título (título en español)', 'titulo', $this->filter_order_Dir, $this->filter_order); ?></th>
				<th class="title"><?php echo JHTML::_('grid.sort', 'Año', 'anno', $this->filter_order_Dir, $this->filter_order); ?></th>
				<th class="title"><?php echo JHTML::_('grid.sort', 'Puntuación', 'puntuacion', $this->filter_order_Dir, $this->filter_order); ?></th>
			</tr>
		</thead>
		
		
		
		<?php
		foreach($this->peliculas as $pelicula){
			$idPelicula = $pelicula["id"];
		?>
			<tr>
				<td><?php echo "<a href='index.php?option=com_peliculas&task=verDetalles&id=$idPelicula'>".$pelicula["titulo"]." (".$pelicula["tituloEspanol"].")"."</a>"; ?></td>
				<td><?php echo $pelicula["anno"]; ?></td>
				<td><?php echo $pelicula["puntuacion"]; ?></td>
			</tr>
		<?php
		}
		?>
		<tfoot>
            <tr>
                <td colspan="6">
                    <?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
        </tfoot>
	</table>
	
	<input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="task" value="vervotadas" />
    <input type="hidden" name="filter_order" value="<?php echo $this->filter_order; ?>" />
    <input type="hidden" name="filter_order_Dir" value="" />
    <input type="hidden" name="filter_state" value="<?php echo $this->filter_state; ?>" />
</form>