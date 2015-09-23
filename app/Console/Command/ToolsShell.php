<?php

class ToolsShell extends AppShell {

    public function main() {
        if (!$this->args) {
        	$this->stdout->styles('cyan', array('text' => 'cyan'));
        	$this->stdout->styles('green', array('text' => 'green'));
        	$this->out('');
        	$this->out('<cyan>AVAILABLE OPTIONS:</cyan>');
        	$this->out('');
        	$this->out('<green>test</green> - run all tests');
        	$this->out('<green>unit</green> - run unit tests');
        	$this->out('<green>int</green> - run integration tests');
        	$this->out('<green>integration</green> - run integration tests');
        	$this->out('');
        }
        else {
            $this->printInvalidCommandError($this->args[0]);
        }
    }

    public function test() {
    	$this->executeTest($this->args);
    }

    public function unit() {
        $args = array_merge(array('unit'), $this->args);
        $this->executeTest($args);
    }

    public function integration() {
        $args = array_merge(array('integration'), $this->args);
        $this->executeTest($args);
    }

    public function int() {
        $args = array_merge(array('int'), $this->args);
        $this->executeTest($args);
    }


    private function executeTest($args) {
        $arg = current($args);

        if (!$arg) {
            // Run all tests
            $command = 'test app All --debug';
        }
        else if ($arg === 'unit') {
            // Run unit tests
            $command = 'test app Unit --debug';
        }
        else if ($arg === 'int' || $arg === 'integration') {
            // Run integration tests
            $command = 'test app Integration --debug';
        }
        else if ($arg === 'coverage') {
            // Run test coverage
            // WARNING: need permission to write in webroot
            $command = 'test app All --coverage-html webroot/coverage';
        }
        else {
            // Run specific test class...
            $command = 'test app ' . $arg;
            if ($secondArg = next($args)) {
                // ...or specific test methods
                $command .= ' --filter ' . $secondArg;
            }
            $command .= ' --debug';
        }

        if ($extra = next($args)) {
            // Unexpected extra argument
            $this->printInvalidCommandError($extra);
        }
        else {
            $this->dispatchShell($command);
        }
    }

    private function printInvalidCommandError($arg) {
        $this->stdout->styles('red', array('text' => 'red', 'bold' => true));
        $this->out('');
        $this->out('<red>Invalid command:</red> ' . $arg);
        $this->out('');
    }
    
}