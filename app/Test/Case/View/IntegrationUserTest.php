<?php

App::uses('SeleniumTestCase', 'Test/Case');
App::uses('CakeEmail', 'Network/Email');

class IntegrationUserTest extends SeleniumTestCase {
    public $fixtures = array('app.user', 'app.hotel');

    public function setUp() {
        parent::setUp();

        $mailer = new CakeEmail();
        $mailer->transport('Debug');
        $user = $this->getMockForModel('User', array('getMailer'));
        $user->expects($this->any())
            ->method('getMailer')
            ->will($this->returnValue($mailer));

        $user->save(
            array(
                'User' => array(
                    'id' => 1,
                    'username' => 'admin',
                    'password' => '123456',
                    'email' => 'admin@user.com',
                    'name' => 'Admin',
                    'role' => 'Administrador',
                ),
            )
        );

        $user->saveAssociated(
            array(
                'User' => array(
                    'id' => 2,
                    'username' => 'cliente',
                    'password' => '123456',
                    'email' => 'cliente@user.com',
                    'name' => 'Cliente',
                    'role' => 'Cliente',
                ),
                'Hotel' => array(
                    'address' => 'Endereço',
                    'city' => 'Niterói',
                    'state' => 'RJ',
                    'latitude' => 0,
                    'longitude' => 0,
                ),
            )
        );
    }

    public function testLoginAsAdmin() {
        $this->login('admin', '123456');
        $h1 = $this->webDriver->findElement(WebDriverBy::cssSelector('h1'));
        $this->assertEquals('Futuro Painel de Controle', $h1->getText());
    }

    public function testLoginAsClient() {
        $this->login('cliente', '123456');
        $h1 = $this->webDriver->findElement(WebDriverBy::cssSelector('h1'));
        $this->assertEquals('Futura Home que aparecerá no Totem', $h1->getText());
    }

    public function testLoginInvalidCredentials() {
        $this->webDriver->get($this->url('/admin9123691737'));
        $this->webDriver->findElement(WebDriverBy::id('UserUsername'))->click();
        $this->webDriver->getKeyboard()->sendKeys('invalid');
        $this->webDriver->findElement(WebDriverBy::id('UserPassword'))->click();
        $this->webDriver->getKeyboard()->sendKeys('123456');
        $this->webDriver->findElement(
            WebDriverBy::cssSelector('#UserLoginForm input[type="submit"]')
        )->click();
        $errorMessage = $this->webDriver->findElement(WebDriverBy::className('post-error'));
        $this->assertEquals('E-mail ou senha incorretos', $errorMessage->getText());
    }

    public function testCreateNewAdmin() {
        $this->login('admin', '123456');
        $this->webDriver->findElement(
            WebDriverBy::linkText('Cadastrar usuário')
        )->click();
        $this->webDriver->findElement(WebDriverBy::id('UserUsername'))->click();
        $this->webDriver->getKeyboard()->sendKeys('admintest');
        $this->webDriver->findElement(WebDriverBy::id('UserName'))->click();
        $this->webDriver->getKeyboard()->sendKeys('Admin Test');
        $this->webDriver->findElement(WebDriverBy::id('UserEmail'))->click();
        $this->webDriver->getKeyboard()->sendKeys('admin@test.com');
        $roleSelect = new WebDriverSelect($this->webDriver->findElement(
            WebDriverBy::id('user-role')
        ));
        $roleSelect->selectByVisibleText('Administrador');
        $this->webDriver->findElement(
            WebDriverBy::cssSelector('#UserCreateForm input[type="submit"]')
        )->click();
        $successMessage = $this->webDriver->findElement(WebDriverBy::className('post-success'));
        $this->assertEquals('Usuário criado com sucesso: e-mail enviado para admin@test.com', $successMessage->getText());

        $this->webDriver->findElement(
            WebDriverBy::linkText('Lista de usuários')
        )->click();

        // Cells in the first column contain the names
        $this->assertExistsElementWithText('td:first-child', 'Admin Test');
    }

    public function testCreateNewClient() {
        $this->login('admin', '123456');
        $this->webDriver->findElement(
            WebDriverBy::linkText('Cadastrar usuário')
        )->click();
        $this->webDriver->findElement(WebDriverBy::id('UserUsername'))->click();
        $this->webDriver->getKeyboard()->sendKeys('clienttest');
        $this->webDriver->findElement(WebDriverBy::id('UserName'))->click();
        $this->webDriver->getKeyboard()->sendKeys('Client Test');
        $this->webDriver->findElement(WebDriverBy::id('UserEmail'))->click();
        $this->webDriver->getKeyboard()->sendKeys('client@test.com');
        $roleSelect = new WebDriverSelect($this->webDriver->findElement(
            WebDriverBy::id('user-role')
        ));
        $roleSelect->selectByVisibleText('Cliente');
        $this->webDriver->findElement(WebDriverBy::id('hotel-address'))->click();
        $this->webDriver->getKeyboard()->sendKeys('Fake Address');
        $this->webDriver->findElement(WebDriverBy::id('hotel-phone'))->click();
        $this->webDriver->getKeyboard()->sendKeys('9876-5432');

        // Simulate latitude and longitude autofilling
        $this->webDriver->executeScript('$("#hotel-city").val("Niterói")', array());
        $this->webDriver->executeScript('$("#hotel-state").val("RJ")', array());
        $this->webDriver->executeScript('$("#hotel-latitude").val(1)', array());
        $this->webDriver->executeScript('$("#hotel-longitude").val(1)', array());

        $this->webDriver->findElement(
            WebDriverBy::cssSelector('#UserCreateForm input[type="submit"]')
        )->click();
        $successMessage = $this->webDriver->findElement(WebDriverBy::className('post-success'));
        $this->assertEquals('Usuário criado com sucesso: e-mail enviado para client@test.com', $successMessage->getText());

        $this->webDriver->findElement(
            WebDriverBy::linkText('Lista de usuários')
        )->click();

        // Cells in the first column contain the names
        $this->assertExistsElementWithText('td:first-child', 'Client Test');
    }

    public function testChangePasswordSuccessfully() {
        $this->login('admin', '123456');
        $this->webDriver->findElement(
            WebDriverBy::linkText('Trocar senha')
        )->click();
        $this->webDriver->findElement(WebDriverBy::id('UserCurrentPassword'))->click();
        $this->webDriver->getKeyboard()->sendKeys('123456');
        $this->webDriver->findElement(WebDriverBy::id('UserPassword'))->click();
        $this->webDriver->getKeyboard()->sendKeys('abcdef');
        $this->webDriver->findElement(WebDriverBy::id('UserPasswordConfirmation'))->click();
        $this->webDriver->getKeyboard()->sendKeys('abcdef');
        $this->webDriver->findElement(
            WebDriverBy::cssSelector('#UserChangePasswordForm input[type="submit"]')
        )->click();
        $successMessage = $this->webDriver->findElement(WebDriverBy::className('post-success'));
        $this->assertEquals('Senha alterada com sucesso', $successMessage->getText());

        $this->webDriver->findElement(
            WebDriverBy::linkText('Logout')
        )->click();
        $this->login('admin', 'abcdef');
        $h1 = $this->webDriver->findElement(WebDriverBy::cssSelector('h1'));
        $this->assertEquals('Futuro Painel de Controle', $h1->getText());
    }

    public function testChangePasswordUnsuccessfully() {
        $this->login('admin', '123456');
        $this->webDriver->findElement(
            WebDriverBy::linkText('Trocar senha')
        )->click();
        $this->webDriver->findElement(WebDriverBy::id('UserCurrentPassword'))->click();
        $this->webDriver->getKeyboard()->sendKeys('1234567');
        $this->webDriver->findElement(WebDriverBy::id('UserPassword'))->click();
        $this->webDriver->getKeyboard()->sendKeys('abcdef');
        $this->webDriver->findElement(WebDriverBy::id('UserPasswordConfirmation'))->click();
        $this->webDriver->getKeyboard()->sendKeys('abcdef');
        $this->webDriver->findElement(
            WebDriverBy::cssSelector('#UserChangePasswordForm input[type="submit"]')
        )->click();
        $successMessage = $this->webDriver->findElement(WebDriverBy::className('post-error'));
        $this->assertEquals('Um erro impediu a alteração de senha', $successMessage->getText());

        $this->webDriver->findElement(
            WebDriverBy::linkText('Logout')
        )->click();
        $this->login('admin', '123456');
        $h1 = $this->webDriver->findElement(WebDriverBy::cssSelector('h1'));
        $this->assertEquals('Futuro Painel de Controle', $h1->getText());
    }

}