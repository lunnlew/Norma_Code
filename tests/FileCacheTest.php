<?php
class FileCacheTest extends PHPUnit_Framework_TestCase {
	public function testCheckOp() {
		$o = \Norma\Service\Cache::getInstance('LAEFile');
		$o->set('k1', 1);
		$this->assertEquals(1, $o->get('k1'));

		$o->set('k2', '2');
		$this->assertEquals('2', $o->get('k2'));
		$this->assertEquals(2, $o->get('k2'));

		$o->set('k3', false);
		$this->assertFalse($o->get('k3'));

		$o->set('k4', true);
		$this->assertTrue($o->get('k4'));

		$o->set('k5', [1, 2, 3, 4]);
		$this->assertNotEquals([1, 2, 3, 4, 5], $o->get('k5'));
		$this->assertEquals([1, 2, 3, 4], $o->get('k5'));

		$o->set('k6', $o);
		$this->assertTrue(is_subclass_of($o->get('k6'), '\Norma\Service\Cache\Base'));

		$o->incr('k1');
		$this->assertEquals(2, $o->get('k1'));
		$o->incr('k1', 2);
		$this->assertEquals(4, $o->get('k1'));

		$o->decr('k2');
		$this->assertEquals(1, $o->get('k2'));
		$o->decr('k2', 0);
		$this->assertEquals(1, $o->get('k2'));
		$o->decr('k2', 'string');
		$this->assertEquals(1, $o->get('k2'));

		$this->assertTrue($o->isExsits('k4'));

		$o->delete('k4');
		$this->assertFalse($o->isExsits('k4'));

	}
}