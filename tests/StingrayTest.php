<?php

use Rwillians\Stingray\Stingray;


/**
 * Class StingrayTest
 * @author Rafael Willians <me@rwillians.com>
 */
class StingrayTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider data
     * @param array $array
     */
    public function testItCanGetValues(array $array)
    {
        $stingray = new Stingray();

        $this->assertEquals('value_1', $stingray::get($array, 'test_1'));
        $this->assertEquals('value_2', $stingray::get($array, 'test_2.test_2_1'));
        $this->assertNull($stingray::get($array, 'non.existent.path'));
        $this->assertNull($stingray::get($array, 'test_2.test_2_1.non-existent'));
    }

    /**
     * @dataProvider data
     * @param array $array
     */
    public function testItCanSetAnValue(array $array)
    {
        $stingray = new Stingray();

        $stingray::set($array, 'test_2.test_2_1', true);
        $stingray::set($array, 'bar', 'foo');
        $stingray::set($array, 'foobar.foo.bar', 'foobar');

        $this->assertTrue($stingray::get($array, 'test_2.test_2_1'));
        $this->assertEquals('foo', $stingray::get($array, 'bar'));
        $this->assertEquals('foobar', $stingray::get($array, 'foobar.foo.bar'));
    }

    public function data()
    {
        $array = [
            'test_1' => 'value_1',
            'test_2' => [
                'test_2_1' => 'value_2',
            ]
        ];

        return [[$array, new ArrayObject($array)]];
    }
}
