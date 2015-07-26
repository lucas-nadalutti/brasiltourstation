<?php

App::uses('SeleniumTestCase', 'Test/Case');

class IntegrationBasicTest extends SeleniumTestCase {
	
	public function testCanAccessWebsite() {
        $this->webDriver->get($this->url('/'));
        $this->assertContains('Projeto Turismo', $this->webDriver->getTitle());
    }

}