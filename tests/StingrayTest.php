<?php

use Rwillians\Stingray\Stingray;


/**
 * Class StingrayTest
 * @author Rafael Willians <me@rwillians.com>
 */
class StingrayTest extends PHPUnit_Framework_TestCase
{
    public function testItCanGetValuesForArrays()
    {
        $array = [
            'test_1' => 'value_1',
            'test_2' => [
                'test_2_1' => 'value_2'
            ],
            'test_3' => [
                'test_3_1' => [ 'value_3' ]
            ],
            'value_4',
        ];

        $stingray = new Stingray();

        $this->assertEquals('value_1', $stingray::get($array, 'test_1'));
        $this->assertEquals('value_2', $stingray::get($array, 'test_2.test_2_1'));
        $this->assertEquals('value_3', $stingray::get($array, 'test_3.test_3_1.0'));
        $this->assertEquals('value_4', $stingray::get($array, 0));
        $this->assertEquals(null, $stingray::get($array, 'test_2.test_2_1.value_2'));
        $this->assertEquals(null, $stingray::get($array, 'test_2.test_2_1.value_3'));
        $this->assertEquals(null, $stingray::get($array, 'test_2.test_2_1.value_2.value_3'));
        $this->assertEquals(null, $stingray::get($array, 'non.existent.path'));
    }

    public function testItCanGetValuesForArrayLikeObjects()
    {
        $array = [
            'test_1' => 'value_1',
            'test_2' => [
                'test_2_1' => 'value_2'
            ],
            'test_3' => [
                'test_3_1' => [ 'value_3' ]
            ],
            'value_4',
        ];

        $object = new ArrayObject($array);

        $stingray = new Stingray();

        $this->assertEquals('value_1', $stingray::get($object, 'test_1'));
        $this->assertEquals('value_2', $stingray::get($object, 'test_2.test_2_1'));
        $this->assertEquals('value_3', $stingray::get($object, 'test_3.test_3_1.0'));
        $this->assertEquals('value_4', $stingray::get($object, 0));
        $this->assertEquals(null, $stingray::get($object, 'test_2.test_2_1.value_2'));
        $this->assertEquals(null, $stingray::get($object, 'test_2.test_2_1.value_3'));
        $this->assertEquals(null, $stingray::get($object, 'test_2.test_2_1.value_2.value_3'));
        $this->assertEquals(null, $stingray::get($object, 'non.existent.path'));
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