<?php 
JHTML::stylesheet('peliculas.css', '/media/com_peliculas/');
?>
<table class="adminform">
	<tr>
		<td width="55%" valign="top">
			<div id="cpanel">
				<div style="float: left;">
					<div class="icon">
						<a class="a2" href="index.php?option=com_peliculas&controller=films&task=display">
							<img alt="Administrar películas" src="/proyecto/media/com_peliculas/iconos/peliculas.png"/>
							<span>Administrar películas</span>
						</a>
					</div>
				</div>
				<div style="float: left;">
					<div class="icon">
						<a class="a2" href="index.php?option=com_peliculas&controller=famosos&task=display">
							<img alt="Administrar famosos" src="/proyecto/media/com_peliculas/iconos/famosos.png"/>
							<span>Administrar famosos</span>
						</a>
					</div>
				</div>
				<div style="float: left;">
					<div class="icon">
						<a class="a2" href="index.php?option=com_peliculas&controller=categorias&task=display">
							<img alt="Administrar categorías" src="/proyecto/media/com_peliculas/iconos/categorias.png"/>
							<span>Administrar categorías</span>
						</a>
					</div>
				</div>
				
			</div>
		</td>
		<td width="45%" valign="top">
			<div id="content-pane" class="pane-sliders">
				<div class="panel">
					
					<div class="jpane-slider content">
						<div style="padding: 5px">
							<span class="titulo">Descripción</span>
							<p>
								Con este componente dispondrás de un recomendador de películas para tu sitio web Joomla!.
								Esperamos que sea de tu agrado.
							</p>
							<span class="titulo">Funcionamiento</span>
							<p>
								Para obtener las películas recomendadas hemos utilizado un algoritmo de filtro colaborativo, el cual se basa 
								en calcular los usuarios que tienen gustos parecidos y mostrar las películas que ellos han visto y 
								valorado positivamente que nosotros no hemos visto.
							</p>
							<span class="titulo">Autores</span>
							<p>
								El componente ha sido desarrollado por Álvaro Tristancho Reyes y Antonio Jesús Viñas Sandiez para 
								el proyecto fin de carrera de Ingeniría Técnica de Informática de Gestión
							</p>
						</div>
					</div>	
				</div>
			</div>
		</td>
	</tr>
</table>