<?php
defined('_JEXEC') or die('Restricted access');

$filename = 'table-ordering.js';
$path = '/media/system/js/';
JHTML::script($filename, $path);
$filename ='ajaxVotacion.js';
JHTML::script($filename, $path);
JHTML::stylesheet('peliculas.css', '/media/com_peliculas/');
?>
<form name="userForm" method="post" action="index.php">
    <div class="clear">

        <?php
        if (isset($this->peliculas)) {
            ?>

            <table>
                <thead>
                    
                </thead>


                <?php
                $paginacion = TRUE;
                if (count($this->peliculas) > 0) {
                    foreach ($this->peliculas as $pelicula) {
                        $idPelicula = $pelicula["id"];
                        ?>
                        <tr>
                            <td><?php echo "<a href='index.php?option=com_peliculas&task=verDetalles&id=$idPelicula'>" . $pelicula["titulo"] . " (" . $pelicula["tituloEspanol"] . ")" . "</a>"; ?></td>
                            <td><?php echo $pelicula["anno"]; ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    $paginacion = FALSE;
                    echo "No se han encontrado películas";
                }
                ?>
                
            </table>
            <?php }
        ?>	
    </div>
    <input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="task" value="busquedaAvanzada" />
    <input type="hidden" name="paginacion" value="<?php echo base64_encode(serialize($paginacion)); ?>" />
    <input type="hidden" name="filter_order" value="<?php echo $this->filter_order; ?>" />
    <input type="hidden" name="filter_order_Dir" value="" />
    <input type="hidden" name="filter_state" value="<?php echo $this->filter_state; ?>" />
    <input type="hidden" name="camposPrevios" value="<?php echo base64_encode(serialize($this->camposPrevios)); ?>" />
</form>