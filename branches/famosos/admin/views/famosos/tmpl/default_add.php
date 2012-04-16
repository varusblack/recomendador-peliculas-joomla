<?php
defined('_JEXEC') or die('Restricted access');
?>
<form action="index.php" method="post" name="adminForm">
    <table class="admintable">
        <tr>
            <td width="100" align="right" class="key">
                <label for="nombre">Nombre:</label>
            </td>
            <td>
                <input type="text" name="nombre" id="nombre" maxlength="300" />
            </td>
        </tr>


    </table>
    <input type="hidden" name="option" value="com_famosos" />
    <input type="hidden" name="id" value="" />
    <input type="hidden" name="task" value="" />
</form>