<div class="">
	<form class="" action="index.php" method="post">
		<h2>Buscar películas</h2>
		<input type="text" id="tituloBuscado" name="tituloBuscado"/>
		<button type="submit">Buscar</button>		
		
		<input type="hidden" name="option" value="com_peliculas" />
	    <input type="hidden" name="controller" value="films" />
	    <input type="hidden" name="task" value="busquedaRapida" />
	</form>
</div>
<a href="index.php?option=com_peliculas&controller=Films&task=prepararBusquedaAvanzada">Búsqueda avanzada</a>