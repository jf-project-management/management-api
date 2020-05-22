<?php


namespace App\Tests\Core;


use App\Entity\Task;
use App\Entity\User;
use App\Tests\CommonInitializer;

class TaskTest extends CommonInitializer
{
    public function testSimpleInitializer()
    {
        $task = new Task();
        $user = new User();
        $task->setCreatedBy($user);
        $this->assertEmpty($task->getId());
        $this->assertEquals($user, $task->getCreatedBy());
    }

    public function testSearchTask()
    {
        $name = "Task 1";
        $task = $this->entityManager
            ->getRepository(Task::class)
            ->findOneBy(['name' => $name]);

        $this->assertSame($name, $task->getName());
    }
}