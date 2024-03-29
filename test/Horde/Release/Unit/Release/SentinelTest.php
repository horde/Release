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
 * @license    http://www.horde.org/licenses/lgpl21 LGPL 2.1
 */
namespace Horde\Release\Unit\Release;
use Horde\Release\TestCase;
use \Horde_Release_Sentinel;

/**
 * Test the sentinel modifications.
 *
 * Copyright 2011-2017 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category   Horde
 * @package    Release
 * @subpackage UnitTests
 * @author     Gunnar Wrobel <wrobel@pardus.de>
 * @license    http://www.horde.org/licenses/lgpl21 LGPL 2.1
 */
class SentinelTest extends TestCase
{
    public function testUpdateSentinel()
    {
        $tmp_dir = $this->getTemporaryDirectory();
        $sentinel = new Horde_Release_Sentinel($tmp_dir);
        mkdir($tmp_dir . '/doc');
        file_put_contents($tmp_dir . '/doc/CHANGES', "\n=OLD=\n");
        $sentinel->updateChanges('1.0.0');
        $this->assertEquals(
            '------
v1.0.0
------




=OLD=
',
            file_get_contents($tmp_dir . '/doc/CHANGES')
        );
    }

    public function testUpdateSentinelWithHorde5()
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
        mkdir($tmp_dir . '/doc');
        file_put_contents($tmp_dir . '/doc/CHANGES', "---\nOLD\n---\nTEST");
        $sentinel->replaceChanges('1.0.0');
        $this->assertEquals(
            '------
v1.0.0
------
TEST',
            file_get_contents($tmp_dir . '/doc/CHANGES')
        );
    }

    public function testReplaceSentinelWithHorde5()
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
        $mode = fileperms($tmp_dir . '/lib/Application.php');
        $sentinel->updateApplication('1.0.0');
        $this->assertEquals(
            'class Application {
public $version = \'1.0.0\';
}
',
            file_get_contents($tmp_dir . '/lib/Application.php')
        );
        clearstatcache();
        $this->assertEquals($mode, fileperms($tmp_dir . '/lib/Application.php'));
    }

    public function testUpdateBundle()
    {
        $tmp_dir = $this->getTemporaryDirectory();
        $sentinel = new Horde_Release_Sentinel($tmp_dir);
        mkdir($tmp_dir . '/lib');
        file_put_contents($tmp_dir . '/lib/Bundle.php', "class Horde_Bundle {\nconst VERSION = '0.0.0';\n}\n");
        $mode = fileperms($tmp_dir . '/lib/Bundle.php');
        $sentinel->updateApplication('1.0.0');
        $this->assertEquals(
            'class Horde_Bundle {
const VERSION = \'1.0.0\';
}
',
            file_get_contents($tmp_dir . '/lib/Bundle.php')
        );
        clearstatcache();
        $this->assertEquals($mode, fileperms($tmp_dir . '/lib/Bundle.php'));
    }
}
