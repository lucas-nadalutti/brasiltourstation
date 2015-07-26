<?php

class SeleniumTestCase extends CakeTestCase {

    protected $webDriver;

    private $baseUrl = 'http://localhost/projetoturismo';

    public function setUp() {
        parent::setUp();

        // Set User-Agent so CakePHP uses the appropriate test environment
        $profile = new FirefoxProfile();
        $profile->setPreference('general.useragent.override', 'selenium');

        $capabilities = DesiredCapabilities::firefox();
        $capabilities->setCapability(FirefoxDriver::PROFILE, $profile);
        $this->webDriver = RemoteWebDriver::create(
            'http://localhost:4444/wd/hub',
            $capabilities
        );
    }

    public function tearDown() {
        parent::tearDown();

        $this->webDriver->close();
    }

    protected function url($relativePath = '') {
        // Add a '/' to the path in case it doesn't start with one
        if ($relativePath && substr($relativePath, 0, 1) !== '/') {
            $relativePath = '/' . $relativePath;
        }
        return $this->baseUrl . $relativePath;
    }

    protected function login($username, $password) {
        $this->webDriver->get($this->url('/admin9123691737'));
        $this->webDriver->findElement(WebDriverBy::id('UserUsername'))->click();
        $this->webDriver->getKeyboard()->sendKeys($username);
        $this->webDriver->findElement(WebDriverBy::id('UserPassword'))->click();
        $this->webDriver->getKeyboard()->sendKeys($password);
        $this->webDriver->findElement(
            WebDriverBy::cssSelector('#UserLoginForm input[type="submit"]')
        )->click();
    }

    protected function assertExistsElementWithText($selector, $text) {
        // Get all elements that match the given selector
        $elements = $this->webDriver->findElements(
            WebDriverBy::cssSelector($selector)
        );
        $elementExists = false;
        foreach($elements as $element) {
            if ($element->getText() === $text) {
                $elementExists = true;
                break;
            }
        }
        $this->assertTrue($elementExists);
    }
}