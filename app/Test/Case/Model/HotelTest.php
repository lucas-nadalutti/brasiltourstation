<?php

App::uses('User', 'Model');
App::uses('CakeEmail', 'Network/Email');

class HotelTest extends CakeTestCase {
	public $fixtures = array('app.user', 'app.hotel', 'app.video', 'app.hotel_video');

	public function setUp() {
		parent::setUp();

        // Mock User's mailer so it returns one that doesn't actually send emails
        $mailer = new CakeEmail();
        $mailer->transport('Debug');
        $model = $this->getMockForModel('User', array('getMailer'));
        $model->expects($this->any())
            ->method('getMailer')
            ->will($this->returnValue($mailer));

        $this->User = $model;
        $this->User->create();
    }

    public function testCreateValidHotel() {
        $this->assertNotEmpty($this->User->saveAssociated(
            array(
                'User' => array(
                    'username' => 'hotel',
                    'email' => 'valid@hotel.com',
                    'name' => 'Hotel',
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
        ));
        $this->assertTrue($this->User->Hotel->hasAny());
    }

    public function testCreateHotelWithoutAddress() {
        $this->assertFalse($this->User->saveAssociated(
            array(
                'User' => array(
                    'username' => 'hotel',
                    'email' => 'valid@hotel.com',
                    'name' => 'Hotel',
                    'role' => 'Cliente',
                ),
                'Hotel' => array(
                    'city' => 'Niterói',
                    'state' => 'RJ',
                    'latitude' => 0,
                    'longitude' => 0,
                ),
            )
        ));
        $this->assertEquals(
            array(
                'Hotel' => array(
                    'address' => array(
                        'Este campo é obrigatório'
                    )
                )
            ),
            $this->User->validationErrors
        );
    }

    public function testCreateHotelWithEmptyAddress() {
        $this->assertFalse($this->User->saveAssociated(
            array(
                'User' => array(
                    'username' => 'hotel',
                    'email' => 'valid@hotel.com',
                    'name' => 'Hotel',
                    'role' => 'Cliente',
                ),
                'Hotel' => array(
                    'address' => '',
                    'city' => 'Niterói',
                    'state' => 'RJ',
                    'latitude' => 0,
                    'longitude' => 0,
                ),
            )
        ));
        $this->assertEquals(
            array(
                'Hotel' => array(
                    'address' => array(
                        'Este campo é obrigatório'
                    )
                )
            ),
            $this->User->validationErrors
        );
    }

    public function testCreateHotelWithoutCity() {
        $this->assertFalse($this->User->saveAssociated(
            array(
                'User' => array(
                    'username' => 'hotel',
                    'email' => 'valid@hotel.com',
                    'name' => 'Hotel',
                    'role' => 'Cliente',
                ),
                'Hotel' => array(
                    'address' => 'Endereço',
                    'state' => 'RJ',
                    'latitude' => 0,
                    'longitude' => 0,
                ),
            )
        ));
        $this->assertEquals(
            array(
                'Hotel' => array(
                    'city' => array(
                        'Este campo é obrigatório'
                    )
                )
            ),
            $this->User->validationErrors
        );
    }

    public function testCreateHotelWithEmptyCity() {
        $this->assertFalse($this->User->saveAssociated(
            array(
                'User' => array(
                    'username' => 'hotel',
                    'email' => 'valid@hotel.com',
                    'name' => 'Hotel',
                    'role' => 'Cliente',
                ),
                'Hotel' => array(
                    'address' => 'Endereço',
                    'city' => '',
                    'state' => 'RJ',
                    'latitude' => 0,
                    'longitude' => 0,
                ),
            )
        ));
        $this->assertEquals(
            array(
                'Hotel' => array(
                    'city' => array(
                        'Este campo é obrigatório'
                    )
                )
            ),
            $this->User->validationErrors
        );
    }

    public function testCreateHotelWithoutState() {
        $this->assertFalse($this->User->saveAssociated(
            array(
                'User' => array(
                    'username' => 'hotel',
                    'email' => 'valid@hotel.com',
                    'name' => 'Hotel',
                    'role' => 'Cliente',
                ),
                'Hotel' => array(
                    'address' => 'Endereço',
                    'city' => 'Niterói',
                    'latitude' => 0,
                    'longitude' => 0,
                ),
            )
        ));
        $this->assertEquals(
            array(
                'Hotel' => array(
                    'state' => array(
                        'Este campo é obrigatório'
                    )
                )
            ),
            $this->User->validationErrors
        );
    }

    public function testCreateHotelWithEmptyState() {
        $this->assertFalse($this->User->saveAssociated(
            array(
                'User' => array(
                    'username' => 'hotel',
                    'email' => 'valid@hotel.com',
                    'name' => 'Hotel',
                    'role' => 'Cliente',
                ),
                'Hotel' => array(
                    'address' => 'Endereço',
                    'city' => 'Niterói',
                    'state' => '',
                    'latitude' => 0,
                    'longitude' => 0,
                ),
            )
        ));
        $this->assertEquals(
            array(
                'Hotel' => array(
                    'state' => array(
                        'Este campo é obrigatório'
                    )
                )
            ),
            $this->User->validationErrors
        );
    }

    public function testCreateHotelWithoutLatitude() {
        $this->assertFalse($this->User->saveAssociated(
            array(
                'User' => array(
                    'username' => 'hotel',
                    'email' => 'valid@hotel.com',
                    'name' => 'Hotel',
                    'role' => 'Cliente',
                ),
                'Hotel' => array(
                    'address' => 'Endereço',
                    'city' => 'Niterói',
                    'state' => 'RJ',
                    'longitude' => 0,
                ),
            )
        ));
        $this->assertEquals(
            array(
                'Hotel' => array(
                    'latitude' => array(
                        'Este campo é obrigatório'
                    )
                )
            ),
            $this->User->validationErrors
        );
    }

    public function testCreateHotelWithEmptyLatitude() {
        $this->assertFalse($this->User->saveAssociated(
            array(
                'User' => array(
                    'username' => 'hotel',
                    'email' => 'valid@hotel.com',
                    'name' => 'Hotel',
                    'role' => 'Cliente',
                ),
                'Hotel' => array(
                    'address' => 'Endereço',
                    'city' => 'Niterói',
                    'state' => 'RJ',
                    'latitude' => '',
                    'longitude' => 0,
                ),
            )
        ));
        $this->assertEquals(
            array(
                'Hotel' => array(
                    'latitude' => array(
                        'Este campo é obrigatório'
                    )
                )
            ),
            $this->User->validationErrors
        );
    }

    public function testHotelGetVideos() {
        $this->User->saveAssociated(
            array(
                'User' => array(
                    'username' => 'hotel',
                    'email' => 'valid@hotel.com',
                    'name' => 'Hotel',
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
        $hotelId = $this->User->Hotel->id;
        $videoModel = ClassRegistry::init('Video');

        $videoModel->create();
        $videoModel->save(
            array(
                'Video' => array(
                    'url' => 'video.mp4',
                    'name' => 'Video',
                    'type' => 'video/mp4',
                ),
                'Hotel' => array(
                    array(
                        'id' => $hotelId,
                    ),
                )
            )
        );
        $videoModel->create();
        $videoModel->save(
            array(
                'Video' => array(
                    'url' => 'video2.mp4',
                    'name' => 'Video 2',
                    'type' => 'video/mp4',
                ),
                'Hotel' => array(
                    array(
                        'id' => $hotelId,
                    ),
                )
            )
        );
        $videos = $this->User->Hotel->getVideos();
        $this->assertEquals(
            2,
            count($videos)
        );
    }
}