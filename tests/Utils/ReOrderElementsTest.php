<?php

namespace App\Tests\Utils;

use App\Utils\Utils;
use PHPUnit\Framework\TestCase;

class ReOrderElementsTest extends TestCase
{
    private $elements = [
        0 => [ "initial" => 0 ],
        1 => [ "initial" => 1 ],
        2 => [ "initial" => 2 ],
        3 => [ "initial" => 3 ],
        4 => [ "initial" => 4 ],
        5 => [ "initial" => 5 ],
        ];

    public function testChangeOrder2To4()
    {
        $newArray = Utils::moveValueByIndex($this->elements, 2, 4);
        $this->assertEquals(0, $newArray[0]['initial']);
        $this->assertEquals(1, $newArray[1]['initial']);
        $this->assertEquals(3, $newArray[2]['initial']);
        $this->assertEquals(4, $newArray[3]['initial']);
        $this->assertEquals(2, $newArray[4]['initial']);
        $this->assertEquals(5, $newArray[5]['initial']);
    }

    public function testChangeOrder5To1()
    {
        $newArray = Utils::moveValueByIndex($this->elements, 5, 1);
        $this->assertEquals(0, $newArray[0]['initial']);
        $this->assertEquals(5, $newArray[1]['initial']);
        $this->assertEquals(1, $newArray[2]['initial']);
        $this->assertEquals(2, $newArray[3]['initial']);
        $this->assertEquals(3, $newArray[4]['initial']);
        $this->assertEquals(4, $newArray[5]['initial']);
    }

    public function testNullParams()
    {
        $newArray = Utils::moveValueByIndex($this->elements, null, 1);
        $this->assertEquals(0, $newArray[0]['initial']);
        $this->assertEquals(5, $newArray[1]['initial']);
        $this->assertEquals(1, $newArray[2]['initial']);
        $this->assertEquals(2, $newArray[3]['initial']);
        $this->assertEquals(3, $newArray[4]['initial']);
        $this->assertEquals(4, $newArray[5]['initial']);

    }
}
