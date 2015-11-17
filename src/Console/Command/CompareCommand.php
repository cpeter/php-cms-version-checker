<?php

namespace Cpeter\PhpCmsVersionChecker\Console\Command;

use Cpeter\PhpCmsVersionChecker\Configuration\Configuration;
use Cpeter\PhpCmsVersionChecker\Parser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CompareCommand extends Command {
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
        
        $parser = new Parser();
        
        foreach($configuration->get("CMS") as $cms => $cms_options){
            $version_id = $parser->parse($cms, $cms_options);
            $output->writeln($version_id);
        }
        
        $duration = microtime(true) - $startTime;
        $output->writeln('');
        $output->writeln('Time: ' . round($duration, 3) . ' seconds, Memory: ' . round(memory_get_peak_usage() / 1024 / 1024, 3) . ' MB');
    }
}