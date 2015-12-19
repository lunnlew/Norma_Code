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

namespace Norma\Server\Cache;

/**
 * 缓存工厂实现
 *
 * @package  Norma\Server\Cache
 * @author    LunnLew <lunnlew@gmail.com>
 * @final
 */
final class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Norma\Server\Cache\Factory::getServerName
     * @covers Norma\Server\Cache\Factory::getRealServerName
     */
    public function testGetServerName()
    {
        $this->assertEquals(
            'LAEFile',
            Factory::getServerName('File')
        );
        $this->assertEquals(
            'LAEFile',
            Factory::getServerName('file')
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
            $this->assertNotFalse(Factory::getRealServerName($value));
        }
        $this->assertEquals(
            'Norma\Server\Cache\Drive\LAEFile',
            Factory::getRealServerName(Factory::getServerName('file'))
        );
        $this->assertEquals(
            'Norma\Server\Cache\Drive\LAEFile',
            Factory::getRealServerName(Factory::getServerName('file'), '')
        );
        $this->assertEquals(
            'Library\Server\Cache\Drive\LAEMemcache',
            Factory::getRealServerName(Factory::getServerName('Memcache'), 'Library')
        );
    }
}
