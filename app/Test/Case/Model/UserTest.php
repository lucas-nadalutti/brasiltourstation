<?php

App::uses('User', 'Model');
App::uses('CakeEmail', 'Network/Email');

class UserTest extends CakeTestCase {
	public $fixtures = array('app.user');

	public function setUp() {
		parent::setUp();

        $mailer = new CakeEmail();
        $mailer->transport('Debug');
        $model = $this->getMockForModel('User', array('getMailer'));
        $model->expects($this->any())
            ->method('getMailer')
            ->will($this->returnValue($mailer));

        $this->User = $model;

        // This is not in fixture records due to the need of password encrypting
        $this->User->save(
            array('User' =>
                array(
                    'id' => 1,
                    'username' => 'existing',
                    'password' => '123456',
                    'email' => 'existing@user.com',
                    'name' => 'User',
                    'role' => 'Administrador',
                )
            )
        );
        $this->User->create();
    }

    public function testCreateValidUser() {
        // Model::save() returns the whole inserted data
        $this->assertNotEmpty($this->User->save(
            array('User' =>
                array(
                    'username' => 'user',
                    'email' => 'valid@user.com',
                    'name' => 'User',
                    'role' => 'Administrador',
                )
            )
        ));
    }

    public function testGeneratedPasswordHasLengthBetween8And15() {
        $this->User->save(
            array('User' =>
                array(
                    'username' => 'user',
                    'email' => 'valid@user.com',
                    'name' => 'User',
                    'role' => 'Administrador',
                )
            )
        );

        $this->assertGreaterThanOrEqual(
            8,
            strlen($this->User->password)
        );

        $this->assertLessThanOrEqual(
            15,
            strlen($this->User->password)
        );
    }

    public function testGeneratedPasswordContainsOnlyLettersAndNumbers() {
        $this->User->save(
            array('User' =>
                array(
                    'username' => 'user',
                    'email' => 'valid@user.com',
                    'name' => 'User',
                    'role' => 'Administrador',
                )
            )
        );        

        $this->assertRegExp(
            '/^[a-zA-Z0-9]+$/',
            $this->User->password
        );
    }

    public function testEmailSender() {
        $this->User->save(
            array('User' =>
                array(
                    'username' => 'user',
                    'email' => 'valid@user.com',
                    'name' => 'User',
                    'role' => 'Administrador',
                )
            )
        );        
        $mailer = $this->User->getMailer();

        $this->assertEquals(
            array('projetoturismohoteis@googlegroups.com' => 'Equipe do Projeto'),
            $mailer->from()
        );
    }

    public function testEmailReceiver() {
        $this->User->save(
            array('User' =>
                array(
                    'username' => 'user',
                    'email' => 'valid@user.com',
                    'name' => 'User',
                    'role' => 'Administrador',
                )
            )
        );        
        $mailer = $this->User->getMailer();

        $this->assertEquals(
            array('valid@user.com' => 'valid@user.com'),
            $mailer->to()
        );
    }

    public function testEmailSubject() {
        $this->User->save(
            array('User' =>
                array(
                    'username' => 'user',
                    'email' => 'valid@user.com',
                    'name' => 'User',
                    'role' => 'Administrador',
                )
            )
        );        
        $mailer = $this->User->getMailer();

        $this->assertEquals(
            'Nome do Projeto',
            $mailer->subject()
        );
    }

    public function testEmailMessageContainsCorrectUsername() {
        $this->User->save(
            array('User' =>
                array(
                    'username' => 'user',
                    'email' => 'valid@user.com',
                    'name' => 'User',
                    'role' => 'Administrador',
                )
            )
        );        
        $mailer = $this->User->getMailer();

        $this->assertContains(
            '<p>Nome de Usuário: <strong>user</strong></p>',
            $mailer->message()[0]
        );
    }

    public function testEmailMessageContainsCorrectPassword() {
        $this->User->save(
            array('User' =>
                array(
                    'username' => 'user',
                    'email' => 'valid@user.com',
                    'name' => 'User',
                    'role' => 'Administrador',
                )
            )
        );        
        $mailer = $this->User->getMailer();

        $this->assertContains(
            '<p>Senha: <strong>' . $this->User->password . '</strong></p>',
            $mailer->message()[0]
        );
    }

    public function testCreateUserWithoutUsername() {
        $this->assertFalse($this->User->save(
            array('User' =>
                array(
                    'email' => 'valid@user.com',
                    'name' => 'User',
                    'role' => 'Administrador',
                )
            )
        ));
        $this->assertEquals(
            array(
                'username' => array(
                    'Tamanho mínimo de 4 caracteres'
                )
            ),
            $this->User->validationErrors
        );
    }

    public function testCreateUserWithExistingUsername() {
        $this->assertFalse($this->User->save(
            array('User' =>
                array(
                    'username' => 'existing',
                    'email' => 'valid@user.com',
                    'name' => 'User',
                    'role' => 'Administrador',
                )
            )
        ));
        $this->assertEquals(
            array(
                'username' => array(
                    'Já existe um usuário registrado com este login'
                )
            ),
            $this->User->validationErrors
        );
    }

    public function testCreateUserWithInvalidUsername() {
        $this->assertFalse($this->User->save(
            array('User' =>
                array(
                    'username' => 'use',
                    'email' => 'valid@user.com',
                    'name' => 'User',
                    'role' => 'Administrador',
                )
            )
        ));
        $this->assertEquals(
            array(
                'username' => array(
                    'Tamanho mínimo de 4 caracteres'
                )
            ),
            $this->User->validationErrors
        );
    }

    public function testCreateUserWithoutEmail() {
        $this->assertFalse($this->User->save(
            array('User' =>
                array(
                    'username' => 'user',
                    'name' => 'User',
                    'role' => 'Administrador',
                )
            )
        ));
        $this->assertEquals(
            array(
                'email' => array(
                    'Este não parece ser um endereço de e-mail válido'
                )
            ),
            $this->User->validationErrors
        );
    }

    public function testCreateUserWithExistingEmail() {
        $this->assertFalse($this->User->save(
            array('User' =>
                array(
                    'username' => 'valid',
                    'email' => 'existing@user.com',
                    'name' => 'User',
                    'role' => 'Administrador',
                )
            )
        ));
        $this->assertEquals(
            array(
                'email' => array(
                    'Já existe um usuário registrado com este e-mail'
                )
            ),
            $this->User->validationErrors
        );
    }

    public function testCreateUserWithInvalidEmail() {
        $this->assertFalse($this->User->save(
            array('User' =>
                array(
                    'username' => 'valid',
                    'email' => 'invalid',
                    'name' => 'User',
                    'role' => 'Administrador',
                )
            )
        ));
        $this->assertEquals(
            array(
                'email' => array(
                    'Este não parece ser um endereço de e-mail válido'
                )
            ),
            $this->User->validationErrors
        );
    }

    public function testCreateUserWithNoName() {
        $this->assertFalse($this->User->save(
            array('User' =>
                array(
                    'username' => 'valid',
                    'email' => 'valid@user.com',
                    'role' => 'Administrador',
                )
            )
        ));
        $this->assertEquals(
            array(
                'name' => array(
                    'Este campo é obrigatório'
                )
            ),
            $this->User->validationErrors
        );
    }

    public function testCreateUserWithNoRole() {
        $this->assertFalse($this->User->save(
            array('User' =>
                array(
                    'username' => 'valid',
                    'email' => 'valid@user.com',
                    'name' => 'User',
                )
            )
        ));
        $this->assertEquals(
            array(
                'role' => array(
                    'Este campo é obrigatório'
                )
            ),
            $this->User->validationErrors
        );
    }

    public function testChangePasswordCorrectly() {
        $this->assertNotEmpty($this->User->save(
            array('User' =>
                array(
                    'id' => 1,
                    'current_password' => '123456',
                    'password' => '654321',
                    'password_confirmation' => '654321',
                )
            )
        ));
    }

    public function testChangePasswordWrongCurrentPassword() {
        $this->assertFalse($this->User->save(
            array('User' =>
                array(
                    'id' => 1,
                    'current_password' => '12345',
                    'password' => '654321',
                    'password_confirmation' => '654321',
                )
            )
        ));
        $this->assertEquals(
            array(
                'current_password' => array(
                    'Senha incorreta'
                )
            ),
            $this->User->validationErrors
        );
    }

    public function testChangePasswordConfirmationDoesNotMatch() {
        $this->assertFalse($this->User->save(
            array('User' =>
                array(
                    'id' => 1,
                    'current_password' => '123456',
                    'password' => '654321',
                    'password_confirmation' => '65432',
                )
            )
        ));
        $this->assertEquals(
            array(
                'password_confirmation' => array(
                    'Senha e confirmação devem ser iguais'
                )
            ),
            $this->User->validationErrors
        );
    }

}