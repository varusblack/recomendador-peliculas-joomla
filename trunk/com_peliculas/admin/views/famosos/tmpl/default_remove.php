<?php
defined('_JEXEC') or die('Restricted access');
?>
<form action="index.php" method="post" name="adminForm">
    <table class="admintable">
        <tr>
            <th>Famosos a borrar</th>
        </tr>
        <tr>
            
            <td>
                <ul>
                <?php
                foreach($this->famosos as $famoso){
                    echo "<li>".$famoso['nombre']."</li>";
                    
                }
                ?>
                </ul>
                <p>¡¡¡Todos estos famosos se borrarán y no se podrá deshacer!!!</p>
                
            </td>
        </tr>


    </table>
    <input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="controller" value="Famosos" />
    <input type="hidden" name="task" value="delete" />
    <input type="hidden" name="cid" value="<?php JRequest::getVar('cid',0,'','array'); ?>" />
    
</form>