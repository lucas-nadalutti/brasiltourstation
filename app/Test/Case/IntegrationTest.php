<?php

/*
 * Custom test suite to execute all app integration tests
 * Command: Console/cake test app Integration
 */

class IntegrationTest extends PHPUnit_Framework_TestSuite {

    public static function suite() {
        $path = APP . 'Test' . DS . 'Case' . DS;

        $suite = new CakeTestSuite('Integration Tests');
        $suite->addTestDirectory($path . 'View' . DS);
        return $suite;
    }

}