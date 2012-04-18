<?php
defined('_JEXEC') or die('Restricted access');
?>

<form action="index.php" method="post" name="adminForm">
    <table class="adminlist">
        <thead>
            <tr>
                <th width="5">Id</th>
                <th width="20">
                    <input type="checkbox" name="toogle" value="" onclick="checkAll(<?php echo count($this->categorias); ?>);" />
                </th>
                <th>Nombre de la categoría</th>
            </tr>
        </thead>
        <?php
        $i = 0;
        foreach ($this->categorias as $categoria) {
            ?>
            <tr>
                <td><?php echo $categoria["id"]; ?></td>
                <td><?php echo JHtml::_('grid.id', $i, $categoria["id"]); ?></td>
                <td>
                    <?php echo "<a href='index.php?option=com_peliculas&controller=Categorias&task=edit&cid[]={$categoria['id']}'>{$categoria['categoria']}</a>"; ?> 
                </td>
            </tr>
            <?php
            $i++;
        }
        ?>
    </table>
    <input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="controller" value="Categorias" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
</form>