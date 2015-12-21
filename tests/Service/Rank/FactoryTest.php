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

namespace Norma\Service\Rank;

/**
 * @package  Norma\Service\Rank
 * @author    LunnLew <lunnlew@gmail.com>
 * @final
 */
final class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Norma\Service\Rank\Factory::getServiceName
     * @covers Norma\Service\Rank\Factory::getRealServiceName
     */
    public function testGetServiceName()
    {
        $this->assertEquals(
            'LAERank',
            Factory::getServiceName('rank')
        );
        $this->assertEquals(
            'LAERank',
            Factory::getServiceName('Rank')
        );
        $arr_name = array(
            'LAERank',
            'SAERank',
            'BAERank',
        );
        foreach ($arr_name as $value) {
            $this->assertNotFalse(Factory::getRealServiceName($value));
        }
        $this->assertEquals(
            'Norma\Service\Rank\Drive\LAERank',
            Factory::getRealServiceName(Factory::getServiceName('rank'))
        );
        $this->assertEquals(
            'Norma\Service\Rank\Drive\LAERank',
            Factory::getRealServiceName(Factory::getServiceName('rank'), '')
        );
        $this->assertNotFalse(
            'Norma\Service\Rank\Drive\LAERank',
            Factory::getRealServiceName(Factory::getServiceName('file'), '')
        );
        $this->assertEquals(
            'Library\Service\Rank\Drive\LAERank',
            Factory::getRealServiceName(Factory::getServiceName('rank'), 'Library')
        );
    }
}
