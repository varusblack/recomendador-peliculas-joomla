<?php
	defined('_JEXEC') or die('Restricted access');
?>

<form action="index.php" method="post" name="adminForm">
    <table class="adminlist">
        <thead>
            <tr>
                <th width="5">Id</th>
                <th width="20">
                    <input type="checkbox" name="toogle" value="" onclick="checkAll(<?php echo count($this->films); ?>);" />
                </th>
                <th>Título</th>
                <th>Año</th>
                <th>Salida a la venta</th>
                <th>Url IMDB</th>
                <th>Título 2</th>
                <th>Título en español</th>
                <th>Url cartel</th>
                <th>Director</th>
            </tr>
        </thead>
        <?php
        $i = 0;
        foreach ($this->films as $film) {
            ?>
            <tr>
                <td><?php echo $film["id"]; ?></td>
                <td><?php echo JHtml::_('grid.id', $i, $film["id"]); ?></td>
                <td>
                    <?php echo "<a href='index.php?option=com_peliculas&controller=Films&task=edit&cid[]={$film['id']}'>{$film['titulo']}</a>"; ?> 
                </td>
                <td><?php echo $film["anno"] ; ?></td>
                <td><?php echo $film["videoRelease"]; ?></td>
                <td><?php echo $film["imdbUrl"]; ?></td>
                <td><?php echo $film["titulo2"]; ?></td>
                <td><?php echo $film["tituloEsp"]; ?></td>
                <td><?php echo $film["urlCartel"]; ?></td>
                
                <!-- Bucle para poder sacar el nombre del dirtector -->
                <?php
                	foreach ($this->famosos as $famoso){
                		if ($film["idDirector"] == $famoso["id"]){
                			$nombreDirector = $famoso["nombre"];
                			echo "<td> $nombreDirector  </td>";
							break;
                		}
                	} 
                ?>
<!--                 <td><?php echo $this->famosos[""]; ?></td> -->
            </tr>
            <?php
            $i++;
        }
        ?>
        <tfoot>
            <tr>
                <td colspan="3">
                    <?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="controller" value="films" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="view" value="" />
</form>