<?php

App::uses('SeleniumTestCase', 'Test/Case');
App::uses('CakeEmail', 'Network/Email');

class IntegrationVideoTest extends SeleniumTestCase {
    public $fixtures = array(
        'app.user',
        'app.hotel',
        'app.video',
        'app.hotel_video'
    );

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

    public function testCreateVideo() {
        $this->login('admin', '123456');
        $this->webDriver->findElement(
            WebDriverBy::linkText('Cadastrar vídeo')
        )->click();
        $this->webDriver->findElement(WebDriverBy::id('VideoName'))->sendKeys(
            'Vídeo Teste'
        );
        $this->webDriver->findElement(
            WebDriverBy::cssSelector('#video-uploading-form input[type="file"]')
        )->sendKeys('~/Downloads/oceans.mp4');
        $this->webDriver->findElement(WebDriverBy::id('Hotel0Id'))->click();
        $this->webDriver->findElement(
            WebDriverBy::id('start-upload')
        )->click();
        $this->webDriver->wait(5, 500)->until(function ($driver) {
            return $driver->getCurrentURL() === (
                'http://localhost/projetoturismo/users/controlPanel'
            );
        });
        $this->webDriver->findElement(
            WebDriverBy::linkText('Logout')
        )->click();
        $this->login('cliente', '123456');
        $this->webDriver->findElement(
            WebDriverBy::linkText('Passeios turísticos')
        )->click();
        $this->assertExistsElementWithText('h3', 'Vídeo Teste');
    }

}