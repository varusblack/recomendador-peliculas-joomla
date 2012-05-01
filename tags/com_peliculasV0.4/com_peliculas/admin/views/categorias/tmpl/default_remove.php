<?php
defined('_JEXEC') or die('Restricted access');
?>
<form action="index.php" method="post" name="adminForm">
    <table class="admintable">
        <tr>
            <th>Categorías a borrar</th>
        </tr>
        <tr>
            
            <td>
                <ul>
                <?php
                foreach($this->categorias as $categoria){
                    echo "<li>".$categoria['categoria']."</li>";
                    
                }
                ?>
                </ul>
                <p>¡¡¡Todas estas categorias se borrarán y no se podrá deshacer!!!</p>
                
            </td>
        </tr>


    </table>
    <input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="controller" value="Categorias" />
    <input type="hidden" name="task" value="delete" />
    <input type="hidden" name="elementsToDelete" value="<?php echo base64_encode(serialize($this->categorias)); ?>" />
    
</form>