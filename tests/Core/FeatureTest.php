<?php

namespace App\Tests\Core;

use App\Entity\Feature;
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
        $this->assertEquals("Feature 0", $first->getName());
        $this->assertEquals(0, $first->getOrderPosition());
        $this->assertEquals("Feature 1", $second->getName());
        $this->assertEquals(1, $second->getOrderPosition());
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