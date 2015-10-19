<?php

namespace PCs\PhpCmsVersionChecker\Test;

use PCs\PhpCmsVersionChecker\PhpCmsVersionChecker;

class DummyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * A dummy test that calls a beacon method ensuring the class is autolaoded.
     *
     */
    public function testAutoload()
    {
        $class = new PhpCmsVersionChecker();
        $this->assertTrue($class->autoloaded());
    }
}
