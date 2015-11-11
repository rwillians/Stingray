<?php

use Rwillians\Stingray\Stingray;


/**
 * Class StingrayTest
 * @author Rafael Willians <me@rwillians.com>
 */
class StingrayTest extends PHPUnit_Framework_TestCase
{
    public function testItCanGetValues()
    {
        $array = [
            'test_1' => 'value_1',
            'test_2' => [
                'test_2_1' => 'value_2'
            ]
        ];

        $this->assertEquals('value_1', Stingray::get($array, 'test_1'));
        $this->assertEquals('value_2', Stingray::get($array, 'test_2.test_2_1'));
        $this->assertEquals(null, Stingray::get($array, 'non.existent.path'));
    }

    public function testItCanSetAnValue()
    {
        $array = [
            'test_1' => [
                'test_1_1' => 'value_1'
            ],
            'test_2' => [
                'test_2_1' => false
            ]
        ];

        Stingray::set($array, 'test_2.test_2_1', true);
        Stingray::set($array, 'bar', 'foo');
        Stingray::set($array, 'foobar.foo.bar', 'foobar');

        $this->assertEquals('value_1', Stingray::get($array, 'test_1.test_1_1'));
        $this->assertEquals(true, Stingray::get($array, 'test_2.test_2_1'));
        $this->assertEquals('foo', Stingray::get($array, 'bar'));
        $this->assertEquals('foobar', Stingray::get($array, 'foobar.foo.bar'));
    }
}