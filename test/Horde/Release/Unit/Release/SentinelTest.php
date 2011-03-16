<?php
/**
 * Test the sentinel modifications.
 *
 * PHP version 5
 *
 * @category   Horde
 * @package    Release
 * @subpackage UnitTests
 * @author     Gunnar Wrobel <wrobel@pardus.de>
 * @license    http://www.fsf.org/copyleft/lgpl.html LGPL
 * @link       http://pear.horde.org/index.php?package=Release
 */

/**
 * Prepare the test setup.
 */
require_once dirname(__FILE__) . '/../../Autoload.php';

/**
 * Test the sentinel modifications.
 *
 * Copyright 2011 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @category   Horde
 * @package    Release
 * @subpackage UnitTests
 * @author     Gunnar Wrobel <wrobel@pardus.de>
 * @license    http://www.fsf.org/copyleft/lgpl.html LGPL
 * @link       http://pear.horde.org/index.php?package=Release
 */
class Horde_Release_Unit_Release_SentinelTest
extends Horde_Release_TestCase
{
    public function testUpdateSentinel()
    {
        $tmp_dir = $this->getTemporaryDirectory();
        $sentinel = new Horde_Release_Sentinel($tmp_dir);
        mkdir($tmp_dir . '/docs');
        file_put_contents($tmp_dir . '/docs/CHANGES', "\n=OLD=\n");
        $sentinel->updateChanges('1.0.0');
        $this->assertEquals(
            '------
v1.0.0
------





=OLD=
',
            file_get_contents($tmp_dir . '/docs/CHANGES')
        );
    }

    public function testReplaceSentinel()
    {
        $tmp_dir = $this->getTemporaryDirectory();
        $sentinel = new Horde_Release_Sentinel($tmp_dir);
        mkdir($tmp_dir . '/docs');
        file_put_contents($tmp_dir . '/docs/CHANGES', "---\nOLD\n---\nTEST");
        $sentinel->replaceChanges('1.0.0');
        $this->assertEquals(
            '------
v1.0.0
------
TEST',
            file_get_contents($tmp_dir . '/docs/CHANGES')
        );
    }

    public function testUpdateApplication()
    {
        $tmp_dir = $this->getTemporaryDirectory();
        $sentinel = new Horde_Release_Sentinel($tmp_dir);
        mkdir($tmp_dir . '/lib');
        file_put_contents($tmp_dir . '/lib/Application.php', "class Application {\npublic \$version = '0.0.0';\n}\n");
        $sentinel->updateApplication('1.0.0');
        $this->assertEquals(
            'class Application {
public $version = \'1.0.0\';
}
',
            file_get_contents($tmp_dir . '/lib/Application.php')
        );
    }
}