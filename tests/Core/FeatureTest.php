<?php

namespace App\Tests\Core;

use App\Entity\Epic;
use App\Entity\Feature;
use App\Entity\History;
use App\Tests\CommonInitializer;

class FeatureTest extends CommonInitializer
{
    private $features = [];
    private $epic;

    public function testOrderFeature()
    {
        $this->createFeatures();
        $first = $this->features[0];
        $second = $this->features[1];
        $this->assertEmpty($first->getId());
        $this->assertEquals("Feature 0", $first->getName());
        $this->assertEquals(0, $first->getOrderPosition());
        $this->assertEquals("Feature 1", $second->getName());
        $this->assertEquals(1, $second->getOrderPosition());
    }

    public function testAddRemoveHistory()
    {
        $this->createFeatures();
        $second = $this->features[1];
        $history = new History();
        $second->addHistory($history);

        $this->assertNotEmpty($second->getHistories());
        $second->removeHistory($history);
        $this->assertEmpty($second->getHistories());
    }

    private function createFeatures()
    {
        $epic = new Epic();
        $epic->setName('Epic test');
        $epic->setOrderPosition(1);

        $this->epic = $epic;
        for ($x = 0; $x < 5; $x++) {
            $feature = new Feature();
            $feature->setName("Feature $x");
            $feature->setEpic($epic);
            $feature->setOrderPosition($x);
            array_push($this->features, $feature);
        }
    }
}