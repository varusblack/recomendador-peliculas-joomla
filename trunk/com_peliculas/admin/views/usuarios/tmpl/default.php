<?php
defined('_JEXEC') or die('Restricted access');
?>

<form action="index.php" method="post" name="adminForm">
    <table class="adminlist">
        <thead>
            <tr>
                <th width="5">Id</th>
                <th width="20">
                    <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->usuarios); ?>);" />
                </th>
                
                <th>Usuarios</th>
                <th>Vector</th>
                <th>Ver vecindario</th>
            </tr>
        </thead>
        <?php
        $i = 0;
        foreach ($this->usuarios as $usuario) {
            $link = JRoute::_('index.php?option=com_users&view=user&task=edit&cid[]=' . $usuario["id"]);
            $linkVecindario = JRoute::_('index.php?option=com_peliculas&controller=usuarios&view=vecindario&task=edit&cid[]=' . $usuario["id"]);
            ?>
            <tr>
                <td><?php echo $usuario["id"]; ?></td>
                <td><?php echo JHtml::_('grid.id', $i, $usuario["id"]); ?></td>
                <td>
                    <?php echo "<a href='$link'>{$usuario['name']}</a>"; ?> 
                </td>
                <td>
                    <?php echo "<a href='$link'>{$usuario['vector']}</a>"; ?> 
                </td>
                <td>
                    <?php echo "<a href='$linkVecindario'>Ver vecindario</a>"; ?> 
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
    <input type="hidden" name="controller" value="Usuarios" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
</form>