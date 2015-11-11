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

        $stingray = new Stingray();

        $this->assertEquals('value_1', $stingray::get($array, 'test_1'));
        $this->assertEquals('value_2', $stingray::get($array, 'test_2.test_2_1'));
        $this->assertEquals(null, $stingray::get($array, 'non.existent.path'));
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

        $stingray = new Stingray();

        $stingray::set($array, 'test_2.test_2_1', true);
        $stingray::set($array, 'bar', 'foo');
        $stingray::set($array, 'foobar.foo.bar', 'foobar');

        $this->assertEquals('value_1', $stingray::get($array, 'test_1.test_1_1'));
        $this->assertEquals(true, $stingray::get($array, 'test_2.test_2_1'));
        $this->assertEquals('foo', $stingray::get($array, 'bar'));
        $this->assertEquals('foobar', $stingray::get($array, 'foobar.foo.bar'));
    }
}