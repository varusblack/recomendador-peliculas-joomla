<?php
    defined('_JEXEC') or die('Restricted access');
?>
<form action="index.php" method="post">
    <input type="text" id="titulo" name="titulo" />
    <input type="hidden" name="option" value="com_libros" />
    <input type="hidden" name="task" value="grabaLibro" />
    <input type="submit" value="Registrar Libro" />
</form>