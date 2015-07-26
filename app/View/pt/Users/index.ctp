<h1>Lista de Usuários</h1>

<table>
	<tr>
		<th>Nome</th>
		<th>Login</th>
		<th>Tipo</th>
		<th>Cadastrado em:</th>
	</tr>
	<?php
		foreach ($users as $user) {
			echo '<tr>';
			echo '<td>' . $user['User']['name'] . '</td>';
			echo '<td>' . $user['User']['username'] . '</td>';
			echo '<td>' . $user['User']['role'] . '</td>';
			echo '<td>';
			echo date('d/m/Y <\b\r> h:i', strtotime($user['User']['created']));
			echo '</td>';
			echo '</tr>';
		}
	?>
</table>