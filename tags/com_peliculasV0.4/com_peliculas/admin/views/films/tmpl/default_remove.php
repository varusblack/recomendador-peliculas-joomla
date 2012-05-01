<?php
defined('_JEXEC') or die('Restricted access');
?>
<form action="index.php" method="post" name="adminForm">
    <table class="admintable">
        <tr>
            <th>Películas a borrar</th>
        </tr>
        <tr>
            
            <td>
                <ul>
                <?php
                foreach($this->films as $film){
                    echo "<li>".$film['titulo']."</li>";
                    
                }
                ?>
                </ul>
                <p>¡¡¡Todas estas películas se borrarán y no se podrá deshacer!!!</p>
                
            </td>
        </tr>


    </table>
    <input type="hidden" name="option" value="com_peliculas" />
    <input type="hidden" name="controller" value="films" />
    <input type="hidden" name="task" value="remove" />
    <input type="hidden" name="elementsToDelete" value="<?php echo base64_encode(serialize($this->films)); ?>" />
    
</form>