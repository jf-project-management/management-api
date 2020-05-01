<?php


namespace App\Tests\Core;


use App\Entity\Task;
use App\Tests\CommonInitializer;

class TaskTest extends CommonInitializer
{
    public function testSimpleInitializer()
    {
        $task = new Task();

        $this->assertEmpty($task->getId());
    }
}