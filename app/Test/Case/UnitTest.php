<?php

/*
 * Custom test suite to execute all app unit tests
 * Command: Console/cake test app Unit
 */

class UnitTest extends PHPUnit_Framework_TestSuite {

    public static function suite() {
        $path = APP . 'Test' . DS . 'Case' . DS;

        $suite = new CakeTestSuite('Unit Tests');
        $suite->addTestDirectory($path . 'Model' . DS);
        return $suite;
    }

}