<?php

use App\Entity\Feature;
use App\Tests\CommonInitializer;
use App\Utils\Utils;

class FeatureRepositoryTest extends CommonInitializer
{
    public function testSearchByName()
    {
        $name = "Feature 1";
        $feature = $this->entityManager
            ->getRepository(Feature::class)
            ->findOneBy(['name' => $name]);

        $this->assertSame($name, $feature->getName());
        $this->assertNotEmpty($feature->getHistories());
    }

    public function testReorderElements()
    {
        $feature = $this->entityManager->getRepository(Feature::class)->findOneBy(['name' => 'Feature 2']);
        $project = $feature->getProject();
        $fromPosition = (int) $feature->getOrderPosition();
        $features = $this->entityManager->getRepository(Feature::class)->findBy(['project' => $project], ['orderPosition' => 'ASC']);

        $this->assertEquals(2, $feature->getOrderPosition());
        Utils::reOrderItems($this->entityManager, $features, $fromPosition, 4);
        $this->assertEquals(4, $feature->getOrderPosition());
    }
}