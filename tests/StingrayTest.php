<?php

use Rwillians\Stingray\Stingray;

require __DIR__.'/Fixtures/ArrayLikeObject.php';
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
            ]
        ];

        $stingray = new Stingray();

        $this->assertEquals('value_1', $stingray::get($array, 'test_1'));
        $this->assertEquals('value_2', $stingray::get($array, 'test_2.test_2_1'));
        $this->assertNull($stingray::get($array, 'non.existent.path'));
        $this->assertNull($stingray::get($array, 'test_2.test_2_1.value_2'));
        $this->assertNull($stingray::get($array, 'test_2.test_2_1.value_2.non-existent'));
        $this->assertNull($stingray::get($array, 'test_2.test_2_1.non-existent'));
    }


    public function testItCanGetValuesForArrayLikeObject()
    {
        $arr = [
            'a' => [
                'b' => [
                    'c' => [
                        'd' => 'e'
                    ]
                ]
            ],
            'f' => 'h'
        ];

        $config = new \ArrayLikeObject($arr);
        $this->assertEquals($arr['a'], Stingray::get($config, 'a')->toArray());

        $this->assertEquals($arr['a']['b'], Stingray::get($config, 'a.b')->toArray());

        $this->assertEquals($arr['a']['b']['c'], Stingray::get($config, 'a.b.c')->toArray());
        $this->assertEquals($arr['a']['b']['c']['d'], Stingray::get($config, 'a.b.c.d'));
        $this->assertEquals($arr['f'], Stingray::get($config, 'f'));

        $this->assertNull(Stingray::get($config, 'a.b.d'));
        $this->assertNull(Stingray::get($config, 'a.b.c.d.e.f.g'));

        $this->assertEquals($arr, $config->toArray());

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