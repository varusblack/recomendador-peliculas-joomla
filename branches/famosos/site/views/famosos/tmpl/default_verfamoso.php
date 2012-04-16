<?php
    defined('_JEXEC') or die('Restricted access');
?>
<form action="index.php" method="post">
    <input type="text" id="nombre" name="nombre" />
    <input type="hidden" name="option" value="com_famosos" />
    <input type="hidden" name="task" value="insertarFamoso" />
    <input type="submit" value="Registrar Famoso" />
</form>