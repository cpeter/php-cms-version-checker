<?php

namespace Cpeter\PhpCmsVersionChecker\Console;

use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Cpeter\PhpCmsVersionChecker\Console\Command\CompareCommand;

class Application extends SymfonyApplication
{

    const VERSION = '@package_version@';
    
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
    
    public function __construct()
    {
        parent::__construct('PHP Versioning Checker', self::VERSION);
    }
    
    public function getHelp()
    {
        return parent::getHelp();
    }
    
    protected function getDefaultCommands()
    {
        $commands = parent::getDefaultCommands();
        $commands[] = $this->add(new CompareCommand());
        return $commands;
    }
    
}
