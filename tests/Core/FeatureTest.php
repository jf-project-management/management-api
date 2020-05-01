<?php

namespace App\Tests\Core;

use App\Entity\Feature;
use App\Entity\History;
use App\Entity\Project;
use PHPUnit\Framework\TestCase;

class FeatureTest extends TestCase
{
    private $features = [];

    protected function setUp()
    {
        parent::setUp();
        $this->createFeatures();
    }

    public function testOrderFeature()
    {
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
        $second = $this->features[1];
        $history = new History();
        $second->addHistory($history);

        $this->assertNotEmpty($second->getHistories());
        $second->removeHistory($history);
        $this->assertEmpty($second->getHistories());
    }

    private function createFeatures()
    {
        $project = new Project();
        for ($x = 0; $x < 5; $x++) {
            $feature = new Feature();
            $feature->setName("Feature $x");
            $feature->setProject($project);
            $feature->setOrderPosition($x);
            array_push($this->features, $feature);
        }
    }
}