<h1>Login</h1>

<?php
	echo $this->Form->create('User', array('action' => 'login', 'autocomplete' => false, 'inputDefaults' => array('format' => array('before', 'error', 'label', 'between', 'input', 'after'))));
	echo $this->Form->input('username', array('label' => 'Login:', 'required' => false));
	echo $this->Form->input('password', array('label' => 'Senha:', 'required' => false));
	echo $this->Form->submit('Entrar', array('class' => 'blue button input-right-spacing', 'div' => false));
	/* echo $this->Html->link(
		'Esqueci minha senha',
		array('action' => 'resetPassword'),
		array('class' => 'orange button')
	);*/
	echo $this->Form->end();
?>