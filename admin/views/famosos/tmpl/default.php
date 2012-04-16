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
                    <?php echo count($this->famosos); ?>
                           );" />
                </th>
                <th>Nombre</th>
            </tr>
        </thead>
        <?php
        $i = 0;
        foreach ($this->famosos as $famoso) {
            ?>
            <tr>
                <td><?php echo $famoso["id"]; ?></td>
                <td><?php echo JHtml::_('grid.id', $i, $famoso["id"]); ?></td>
                <td>
                    <?php echo "<a href='index.php?option=com_famosos&task=edit&cid[]={$famoso['id']}'>{$famoso['nombre']}</a>"; ?> 
                </td>
            </tr>
            <?php
            $i++;
        }
        ?>
    </table>
    <input type="hidden" name="option" value="com_famosos" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
</form>