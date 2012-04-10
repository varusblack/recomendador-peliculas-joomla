<?php
defined('_JEXEC') or die('Restricted access');
?>

<form action="index.php" method="post" name="adminForm">
    <table class="adminlist">
        <thead>
            <tr>
                <th width="5">Id</th>
                <th width="20">
                    <input type="checkbox" name="toogle" valie="" onlick="checkAll(
                    <?php echo count($this->libros); ?>
                           );" />
                </th>
                <th>Título</th>
            </tr>
        </thead>
        <?php
        $i = 0;
        foreach ($this->libros as $libro) {
            ?>
            <tr>
                <td><?php echo $libro["id"]; ?></td>
                <td><?php echo JHtml::_('grid.id', $i, $libro["id"]); ?></td>
                <td>
                    <?php echo "<a href='index.php?option=com_libros&task=edit&cid[]={$libro['id']}'>{$libro['titulo']}</a>"; ?> 
                </td>
            </tr>
            <?php
            $i++;
        }
        ?>
    </table>
    <input type="hidden" name="option" value="com_libros" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
</form>