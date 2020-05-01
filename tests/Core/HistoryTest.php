<?php


namespace App\Tests\Core;

use App\Entity\Feature;
use App\Entity\History;
use App\Entity\Task;
use App\Tests\CommonInitializer;
use App\Utils\Utils;

class HistoryTest extends CommonInitializer
{
    public function testSimpleInitializer()
    {
        $feature = new Feature();
        $history = new History();
        $history->setName('History 1');
        $history->setDescription('Description');
        $history->setOrderPosition(1);
        $history->setFeature($feature);

        $this->assertInstanceOf(History::class, $history);
        $this->assertEmpty($history->getId());
        $this->assertEquals('History 1', $history->getName());
        $this->assertEquals('Description', $history->getDescription());
        $this->assertEquals(1, $history->getOrderPosition());
        $this->assertEquals($feature, $history->getFeature());
    }

    public function testAddAndRemoveTask()
    {
        $history = new History();
        $task1 = new Task();
        $history->addTask($task1);

        $this->assertEquals($task1, $history->getTasks()->first());

        $history->removeTask($task1);
        $this->assertEmpty($history->getTasks());
    }

    public function testGetHistoriesByFeature()
    {
        $feature = $this->entityManager->getRepository(Feature::class)->findOneBy([ 'name' => 'Feature 2' ]);
        $histories = $this->entityManager->getRepository(History::class)->findBy([ 'feature' => $feature ]);
        $firstHistory = $histories[0];
        $this->assertNotEmpty($histories);
        $this->assertNotEmpty($firstHistory->getId());
        $this->assertEquals($feature, $firstHistory->getFeature());
        $this->assertNotEmpty($firstHistory->getTasks());
    }

    public function testReorderHistories()
    {
        $feature = $this->entityManager->getRepository(Feature::class)->findOneBy([ 'name' => 'Feature 3' ]);
        $histories = $this->entityManager->getRepository(History::class)->findBy([ 'feature' => $feature ]);

        $history = $this->entityManager->getRepository(History::class)->find($histories[1]->getId());
        $fromPosition = (int) $history->getOrderPosition();

        $this->assertEquals(1, $fromPosition);
        Utils::reOrderItems($this->entityManager, $histories, $fromPosition, 3);
        $this->assertEquals(3, $history->getOrderPosition());
    }
}