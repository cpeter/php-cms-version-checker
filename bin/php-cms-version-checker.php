#!/usr/bin/env php
<?php
/*
 * This file is part of PHP Copy/Paste Detector (PHPCPD).
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cpliakas\PhpProjectStarter\Console as Console;
use Symfony\Component\Console\Application;

// Try to find the appropriate autoloader.
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
} elseif (__DIR__ . '/../../../autoload.php') {
    require __DIR__ . '/../../../autoload.php';
}

$application = new Application('PHP Project Starter', '@package_version@');
$application->add(new Console\NewCommand());
$application->add(new Console\SelfUpdateCommand());
$application->run();


/*
use Acme\Tool\MyApplication;

$application = new MyApplication();
$application->run();
http://symfony.com/doc/current/components/console/single_command_tool.html

and this 
https://github.com/cpliakas/php-project-starter

*/


