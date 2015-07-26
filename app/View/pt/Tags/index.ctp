<h1>Lista de Tags</h1>

<table>
	<tr>
		<th>Português</th>
		<th>Inglês</th>
		<th>Espanhol</th>
	</tr>
	<?php
		foreach ($tags as $tag) {
			echo '<tr>';
			echo '<td>' . $tag['Tag']['name_pt'] . '</td>';
			echo '<td>' . $tag['Tag']['name_en'] . '</td>';
			echo '<td>' . $tag['Tag']['name_es'] . '</td>';
			echo '</tr>';
		}
	?>
</table>