<?php
defined('_JEXEC') or die('Restricted access');
?>

<form action="index.php" method="post" name="adminForm">
	<table class="adminform">
        <tr>
            <td width="100%">
                Buscar: 
                <input type="text" name="search" id="search" value="<?php echo $this->search; ?>" class="text_area" onChange="document.adminForm.submit();" />
                <button onclick="this.form.submit();">Busca</button>
                <button onclick="this.form.getElementById('search').value='';this.form.submit();"> Quitar filtro </button>
            </td>
            <td nowrap="nowrap"><?php echo $this->filter_state; ?></td>
        </tr>
    </table>
    <table class="adminlist">
        <thead>
            <tr>
                <th width="5">Id</th>
                <th width="20">
                    <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->categorias); ?>);" />
                </th>
                <th class="title"><?php echo JHTML::_('grid.sort', 'Nombre de la categoría', 'categoria', $this->filter_order_Dir, $this->filter_order); ?></th>
            </tr>
        </thead>
        <?php
        $i = 0;
        foreach ($this->categorias as $categoria) {
            $link = JRoute::_('index.php?option=com_peliculas&controller=categorias&cid[]=' . $categoria["id"]);
            ?>
            <tr>
                <td><?php echo $categoria["id"]; ?></td>
                <td><?php echo JHtml::_('grid.id', $i, $categoria["id"]); ?></td>
                <td>
                    <?php echo "<a href='$link'>{$categoria['categoria']}</a>"; ?> 
                </td>
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
    <input type="hidden" name="controller" value="Categorias" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="filter_order" value="<?php echo $this->filter_order; ?>" />
    <input type="hidden" name="filter_order_Dir" value="" />
</form>