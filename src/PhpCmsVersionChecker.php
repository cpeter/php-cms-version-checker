<?php

namespace Cpeter\PhpCmsVersionChecker;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;

class PhpCmsVersionChecker extends Application
{
    /**
     * A method used to test whether this class is autoloaded.
     *
     * @return bool
     *
     * @see \PCs\PhpCmsVersionChecker\Test\DummyTest
     */
    public function autoloaded()
    {
        return   true;
    }
}
