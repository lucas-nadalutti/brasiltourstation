<?php

App::uses('CakeSession', 'Model/Datasource');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
App::uses('Validation', 'Utility');
App::uses('CakeEmail', 'Network/Email');
App::uses('ConnectionManager', 'Model');

class User extends AppModel {

	public $hasOne = 'Hotel';
	
	public $validate = array(
		'username' => array(
			'minLength4' => array(
				'rule' => array('minLength', '4'),
	            'required' => 'create',
				'message' => 'Tamanho mínimo de 4 caracteres'
				),
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'Já existe um usuário registrado com este login'
			)
		),
		'email' => array(
			'valid' => array(
				'rule' => 'email',
            	'required' => 'create',
				'message' => 'Este não parece ser um endereço de e-mail válido'
			),
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'Já existe um usuário registrado com este e-mail'
			)
		),
		'current_password' => array(
			'notBlank' => array(
				'rule' => 'notBlank',
				'message' => 'Este campo é obrigatório'
			),
			'correct' => array(
				'rule' => 'correctPassword',
				'message' => 'Senha incorreta'
			)
		),
		'password' => array(
            'rule' => array('minLength', '6'),
            'required' => 'create',
            'message' => 'Tamanho mínimo de 6 caracteres'
        ),
        'password_confirmation' => array(
            'rule' => 'passwordAndConfirmationMatch',
            'notBlank' => true,
            'message' => 'Senha e confirmação devem ser iguais'
        ),
		'name' => array(
			'rule' => 'notBlank',
            'required' => 'create',
			'message' => 'Este campo é obrigatório'
		),
		'role' => array(
			'rule' => 'notBlank',
            'required' => 'create',
			'message' => 'Este campo é obrigatório'
		),
	);

	public function beforeValidate($options = array()){
		if (!$this->id && !isset($this->data[$this->alias][$this->primaryKey])) {
			// A new user is being created
			$this->password = $this->generatePassword();
			$this->data[$this->alias]['password'] = $this->password;
		}
    	return true;
   }
	
	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			// Hash password before saving
			$passwordHasher = new SimplePasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
				$this->data[$this->alias]['password']
			);
		}
		return true;
	}

	public function saveAssociated($data = null, $options = array()) {
        $role = isset($data[$this->alias]['role']) ? $data[$this->alias]['role'] : null;
        if ($role !== 'Cliente') {
        	unset($data['Hotel']);
        }
        return parent::saveAssociated($data, $options);
    }

    public function afterSave($created, $options = array()) {
    	if ($created) {
    		$emailText  = '<p>' . __('Olá!') . '</p>';
			$emailText .= '<p>' . __('Por favor acesse') . ' <a href="#">www.urldoprojeto.com.br/adminAlgumCodigo</a>.</p>';
			$emailText .= '<p>' . __('Suas credenciais de login são:') . '</p>';
			$emailText .= '<p>' . __('Nome de Usuário:') . ' <strong>' . $this->data['User']['username'] . '</strong></p>';
			$emailText .= '<p>' . __('Senha:') . ' <strong>' . $this->password . '</strong></p>';
			$emailText .= '<p>' . __('Para facilitar a memorização, recomendamos que você troque sua senha clicando na opção correspondente no menu, assim que fizer login.') . '</p>';
			$emailText .= '<p>' . __('Atenciosamente,') . '</p>';
			$emailText .= '<p>' . __('Equipe do Projeto') . '</p>';
			$email = $this->getMailer();
			$email->from(array('projetoturismohoteis@googlegroups.com' => 'Equipe do Projeto'))
				->emailFormat('html')
				->to($this->data['User']['email'])
				->subject(__('Nome do Projeto'))
				->send($emailText);
    	}
    }

    public function getMailer($config = 'default') {
    	$mailer = new CakeEmail($config);
    	// If the browser user is Selenium, do not send an email
    	if (stristr(env('HTTP_USER_AGENT'), 'selenium')) {
    		$mailer->transport('Debug');
    	}
    	return $mailer;
    }
	
	public function correctPassword($check) {
		$passwordHasher = new SimplePasswordHasher();
		$givenPassword = $passwordHasher->hash($check['current_password']);
		$user = $this->findById($this->id);
		if ($user && $givenPassword === $user['User']['password']) {
			return true;	
		}
		return false;
	}
	
	public function passwordAndConfirmationMatch() {
		$userData = $this->data[$this->alias];
		if ($userData['password'] === $userData['password_confirmation']) {
			return true;
		}
		return false;
	}

	private function generatePassword() {
		//upper case "i" and lower case "L" removed on purpose
        $password = substr(
        	str_shuffle(
        		'abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ0123456789'
        	),
        	0,
        	rand(8, 15)
        );
        return $password;
    }

    private function sendEmail() {

    }

}