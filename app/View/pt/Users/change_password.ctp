<h1>Alteração de senha</h1>

<?php
	
	echo $this->Form->create('User', array('inputDefaults' => array('format' => array('before', 'error', 'label', 'between', 'input', 'after'))));
	echo $this->Form->input('current_password', array('label' => 'Senha atual:', 'type' => 'password'));
	echo $this->Form->input('password', array('label' => 'Nova senha:'));
	echo $this->Form->input('password_confirmation', array('label' => 'Confirme a senha:', 'type' => 'password'));
	echo $this->Form->submit('Salvar', array('class' => 'green button input-right-spacing', 'div' => false));
	echo $this->Html->link(
		'Voltar',
		array('action' => 'login')
	);
	echo $this->Form->end();
	
?>