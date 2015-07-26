<?php

/*
 * Custom test suite to execute all app tests
 * Command: Console/cake test app All
 */

class AllTest extends PHPUnit_Framework_TestSuite {

    public static function suite() {
        $path = APP . 'Test' . DS . 'Case' . DS;

        $suite = new CakeTestSuite('All Tests');
        $suite->addTestDirectory($path . 'Controller');
        $suite->addTestDirectory($path . 'Model' . DS);
        $suite->addTestDirectory($path . 'View' . DS);
        return $suite;
    }

}