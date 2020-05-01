<?php


namespace App\Tests\Utils;


use App\Entity\OrderableEntity;
use PHPUnit\Framework\TestCase;

class OrderableEntityTest extends TestCase
{
    public function testValidateProperties()
    {
        $orderable = new OrderableEntity();
        $orderable->setOrderPosition(0);
        $orderable->setDescription('Hello world');
        $orderable->setName('Orderable name');

        $this->assertEquals('Hello world', $orderable->getDescription());
        $this->assertEquals('Orderable name', $orderable->getName());
        $this->assertEquals(0, $orderable->getOrderPosition());
    }
}