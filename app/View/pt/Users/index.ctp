<h1>Lista de Usuários</h1>

<table>
	<tr>
		<th>Nome</th>
		<th>Login</th>
		<th>Tipo</th>
		<th>Data do cadastro</th>
		<th>Último sinal de vida</th>
		<th>Questionário de feedback</th>
	</tr>
	<?php
		foreach ($users as $user) {
			echo '<tr>';
			echo '<td>' . $user['User']['name'] . '</td>';
			echo '<td>' . $user['User']['username'] . '</td>';
			echo '<td>' . $user['User']['role'] . '</td>';
			echo '<td>';
			echo date('d/m/Y <\b\r> H:i', strtotime($user['User']['created']));
			echo '</td>';
			echo '<td>';
			if ($user['User']['role'] === 'Cliente') {
				echo date('d/m/Y <\b\r> H:i', strtotime($user['Hotel']['last_life_sign']));
			}
			echo '</td>';
			echo '<td>';
			if ($user['User']['role'] === 'Cliente') {
				echo $this->Html->link(
					'Acessar',
					array('controller' => 'feedback_questions', 'action' => 'index', $user['Hotel']['id'])
				);
			}
			echo '</td>';
			echo '</tr>';
		}
	?>
</table>