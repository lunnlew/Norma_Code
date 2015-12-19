<?php
// +----------------------------------------------------------------------
// | Norma
// +----------------------------------------------------------------------
// | Copyright (c) 2015  All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author:  LunnLew <lunnlew@gmail.com>
// +----------------------------------------------------------------------

namespace Norma\Server\Rank;

/**
 * @package  Norma\Server\Rank
 * @author    LunnLew <lunnlew@gmail.com>
 * @final
 */
final class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Norma\Server\Rank\Factory::getServerName
     * @covers Norma\Server\Rank\Factory::getRealServerName
     */
    public function testGetServerName()
    {
        $this->assertEquals(
            'LAERank',
            Factory::getServerName('rank')
        );
        $this->assertEquals(
            'LAERank',
            Factory::getServerName('Rank')
        );
        $arr_name = array(
            'LAERank',
            'SAERank',
            'BAERank',
        );
        foreach ($arr_name as $value) {
            $this->assertNotFalse(Factory::getRealServerName($value));
        }
        $this->assertEquals(
            'Norma\Server\Rank\Drive\LAERank',
            Factory::getRealServerName(Factory::getServerName('rank'))
        );
        $this->assertEquals(
            'Norma\Server\Rank\Drive\LAERank',
            Factory::getRealServerName(Factory::getServerName('rank'), '')
        );
        $this->assertNotFalse(
            'Norma\Server\Rank\Drive\LAERank',
            Factory::getRealServerName(Factory::getServerName('file'), '')
        );
        $this->assertEquals(
            'Library\Server\Rank\Drive\LAERank',
            Factory::getRealServerName(Factory::getServerName('rank'), 'Library')
        );
    }
}
