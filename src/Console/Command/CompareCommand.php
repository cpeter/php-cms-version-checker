<?php

namespace Cpeter\PhpCmsVersionChecker\Console\Command;

use Cpeter\PhpCmsVersionChecker as PhpCmsVersionChecker;

use Cpeter\PhpCmsVersionChecker\Configuration\Configuration;

use foo\bar\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CompareCommand extends Command 
{

    protected function configure()
    {
        $this
            ->setName('compare')
            ->setDescription('Compare a set of CMS versions to determine if alert should be sent')
            ->setDefinition([
                new InputOption('config', null, InputOption::VALUE_REQUIRED, 'A configuration file to configure php-semver-checker')
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $startTime = microtime(true);

        $config = $input->getOption('config');
        $configuration = $config ? Configuration::fromFile($config) : Configuration::defaults();
        
        $parser = new PhpCmsVersionChecker\Parser\Parser();
        $storage = PhpCmsVersionChecker\Storage::getConnection($configuration->get("DB"));

        $alert = PhpCmsVersionChecker\Alert::getInstance($configuration->get("Mailer"));
                
        foreach($configuration->get("CMS") as $cms => $cms_options){
            // get version number from the website
            $version_id = $parser->parse($cms, $cms_options);
            
            // get version number stored in local storage
            $stored_version = $storage->getVersion($cms);
            
            // if the two versions are different send out a mail and store the new value in the db
            if (true || $version_id != $stored_version){
                $storage->putVersion($cms, $version_id);

                // send out notification about the version change
                $alert->send($cms, $version_id);
            }
            
            $output->writeln("Version: " . $version_id. ' -> ' . $stored_version);
        }
        
        $duration = microtime(true) - $startTime;
        $output->writeln('');
        $output->writeln('Time: ' . round($duration, 3) . ' seconds, Memory: ' . round(memory_get_peak_usage() / 1024 / 1024, 3) . ' MB');
    }
    
}