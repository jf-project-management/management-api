<?php


namespace App\Tests\Core;

use App\Entity\Feature;
use App\Entity\History;
use App\Tests\CommonInitializer;
use App\Utils\Utils;

class HistoryTest extends CommonInitializer
{
    public function testGetHistoriesByFeature()
    {
        $feature = $this->entityManager->getRepository(Feature::class)->findOneBy([ 'name' => 'Feature 2' ]);
        $histories = $this->entityManager->getRepository(History::class)->findBy([ 'feature' => $feature ]);
        $this->assertNotEmpty($histories);
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