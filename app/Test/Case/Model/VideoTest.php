<?php

App::uses('Video', 'Model');

class VideoTest extends CakeTestCase {
	public $fixtures = array('app.video', 'app.hotel_video');

	public function setUp() {
		parent::setUp();

        $this->Video = ClassRegistry::init('Video');
        $this->Video->create();
    }

    public function testCreateValidVideo() {
        $this->assertNotEmpty($this->Video->save(
            array(
                'Video' => array(
                    'url' => 'video.mp4',
                    'name' => 'Video',
                    'type' => 'video/mp4',
                ),
            )
        ));
    }

    public function testCreateVideoWithoutUrl() {
        $this->assertFalse($this->Video->save(
            array(
                'Video' => array(
                    'name' => 'Video',
                    'type' => 'video/mp4',
                ),
            )
        ));
        $this->assertEquals(
            array(
                'url' => array(
                    'Este campo é obrigatório'
                )
            ),
            $this->Video->validationErrors
        );
    }

    public function testCreateVideoWithEmptyUrl() {
        $this->assertFalse($this->Video->save(
            array(
                'Video' => array(
                    'url' => '',
                    'name' => 'Video',
                    'type' => 'video/mp4',
                ),
            )
        ));
        $this->assertEquals(
            array(
                'url' => array(
                    'Este campo é obrigatório'
                )
            ),
            $this->Video->validationErrors
        );
    }

    public function testCreateVideoWithoutName() {
        $this->assertFalse($this->Video->save(
            array(
                'Video' => array(
                    'url' => 'video.mp4',
                    'type' => 'video/mp4',
                ),
            )
        ));
        $this->assertEquals(
            array(
                'name' => array(
                    'Este campo é obrigatório'
                )
            ),
            $this->Video->validationErrors
        );
    }

    public function testCreateVideoWithEmptyName() {
        $this->assertFalse($this->Video->save(
            array(
                'Video' => array(
                    'url' => 'video.mp4',
                    'name' => '',
                    'type' => 'video/mp4',
                ),
            )
        ));
        $this->assertEquals(
            array(
                'name' => array(
                    'Este campo é obrigatório'
                )
            ),
            $this->Video->validationErrors
        );
    }

    public function testCreateVideoWithoutType() {
        $this->assertFalse($this->Video->save(
            array(
                'Video' => array(
                    'url' => 'video.mp4',
                    'name' => 'Video',
                ),
            )
        ));
        $this->assertEquals(
            array(
                'type' => array(
                    'Este campo é obrigatório'
                )
            ),
            $this->Video->validationErrors
        );
    }

    public function testCreateVideoWithEmptyType() {
        $this->assertFalse($this->Video->save(
            array(
                'Video' => array(
                    'url' => 'video.mp4',
                    'name' => 'Video',
                    'type' => '',
                ),
            )
        ));
        $this->assertEquals(
            array(
                'type' => array(
                    'Este campo é obrigatório'
                )
            ),
            $this->Video->validationErrors
        );
    }

}