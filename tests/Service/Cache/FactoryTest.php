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

namespace Norma\Service\Cache;

/**
 * 缓存工厂实现
 *
 * @package  Norma\Service\Cache
 * @author    LunnLew <lunnlew@gmail.com>
 * @final
 */
final class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Norma\Service\Cache\Factory::getServiceName
     * @covers Norma\Service\Cache\Factory::getRealServiceName
     */
    public function testGetServiceName()
    {
        $this->assertEquals(
            'LAEFile',
            Factory::getServiceName('File')
        );
        $this->assertEquals(
            'LAEFile',
            Factory::getServiceName('file')
        );
        $arr_name = array(
            'LAEFile',
            'LAEMemcache',
            'LAEMemfile',
            'LAEapc',
            'LAEeaccelerator',
            'LAExcache',
            'SAEMemcache',
        );
        foreach ($arr_name as $value) {
            $this->assertNotFalse(Factory::getRealServiceName($value));
        }
        $this->assertEquals(
            'Norma\Service\Cache\Drive\LAEFile',
            Factory::getRealServiceName(Factory::getServiceName('file'))
        );
        $this->assertEquals(
            'Norma\Service\Cache\Drive\LAEFile',
            Factory::getRealServiceName(Factory::getServiceName('file'), '')
        );
        $this->assertNotFalse(
            'Norma\Service\Cache\Drive\LAEFile',
            Factory::getRealServiceName(Factory::getServiceName('other'), '')
        );
        $this->assertEquals(
            'Library\Service\Cache\Drive\LAEMemcache',
            Factory::getRealServiceName(Factory::getServiceName('Memcache'), 'Library')
        );
    }
}
