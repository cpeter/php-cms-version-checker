<?php
/**
 * User: csabap
 * Date: 12/11/2015
 * Time: 12:00 PM
 */

namespace Cpeter\PhpCmsVersionChecker\Test\Configuration;

use Mockery as m;
use Cpeter\PhpCmsVersionChecker\Configuration\Configuration;
use Cpeter\PhpCmsVersionChecker\Test\TestCase;

class ConfigurationTest extends TestCase
{
    /**
     * Check we have a default config file and we can get some values
     * @covers Cpeter\PhpCmsVersionChecker\Configuration\Configuration::defaults
     */
    public function testDefaults()
    {
        $configuration = Configuration::defaults();
        $config = $configuration->get("CMS");
        $this->assertTrue(is_array($config) && !empty($config));
    }

    /**
     * Check default value works
     * @covers Cpeter\PhpCmsVersionChecker\Configuration\Configuration::get
     */
    public function testGet()
    {
        $configuration = Configuration::defaults();
        $config = $configuration->get('invalid', 'default');
        $this->assertTrue($config == 'default');
    }
}
