<h1>Lista de Atrações</h1>

<table>
	<tr>
		<th>Nome</th>
		<th>Endereço</th>
		<th>Total de Visitas</th>
	</tr>
	<?php
		foreach ($attractions as $attraction) {
			echo '<tr>';
			echo '<td>' . $attraction['Attraction']['name'] . '</td>';
			echo '<td>' . $attraction['Attraction']['address'] . '</td>';
			// TODO
			echo '<td>' . 0 . '</td>';
			echo '</tr>';
		}
	?>
</table>