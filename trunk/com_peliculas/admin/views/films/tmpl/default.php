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
                <th class="title"><?php echo JHTML::_('grid.sort', 'Título', 'titulo', $this->filter_order_Dir, $this->filter_order); ?></th>
                <th class="title"><?php echo JHTML::_('grid.sort', 'Título en Español', 'tituloEspanol', $this->filter_order_Dir, $this->filter_order); ?></th>

                <th class="title"><?php echo JHTML::_('grid.sort', 'Año', 'anno', $this->filter_order_Dir, $this->filter_order); ?></th>
                <th class="title"><?php echo JHTML::_('grid.sort', 'Salida a la venta', 'videoRelease', $this->filter_order_Dir, $this->filter_order); ?></th>
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
                    <?php echo "<a href='index.php?option=com_peliculas&controller=Films&task=edit&cid[]={$film['id']}'>{$film["titulo"]}</a>"; ?> 
                </td>
                <td>
                    <?php echo "<a href='index.php?option=com_peliculas&controller=Films&task=edit&cid[]={$film['id']}'>{$film["tituloEspanol"]}</a>"; ?> 
                </td>
                <td><?php echo $film["anno"]; ?></td>
                <td><?php echo $film["videoRelease"]; ?></td>
            </tr>
            <?php
            $i++;
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
    <input type="hidden" name="controller" value="films" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="view" value="" />
    <input type="hidden" name="filter_order" value="<?php echo $this->filter_order; ?>" />
    <input type="hidden" name="filter_order_Dir" value="" />
</form>