<?php

namespace App\Tests\Core;

use App\Entity\Feature;
use App\Entity\Project;
use PHPUnit\Framework\TestCase;

class ProjectTest extends TestCase
{
    /**
     * @var Project
     */
    private Project $project;

    protected function setUp()
    {
        parent::setUp();
        $this->setUpProject();
    }

    public function testCreateProject()
    {
        $this->assertInstanceOf(Project::class, $this->project);
        $this->assertEmpty($this->project->getId());
        $this->assertEquals('Project 1', $this->project->getName());
        $this->assertEquals('Any test', $this->project->getDescription());
    }

    public function testProjectFeatures()
    {
        $feature1 = $this->createFeature('Feature 1');
        $feature2 = $this->createFeature('Feature 2');

        $this->project->addFeature($feature1);
        $this->project->addFeature($feature2);

        $this->assertInstanceOf(Feature::class, $feature1);
        $this->assertNotEmpty($this->project->getFeatures());
        $this->assertEquals(2, count($this->project->getFeatures()));
    }

    public function testRemoveFeaturesByIndex()
    {
        $feature1 = $this->createFeature('Feature');
        $this->project->addFeature($feature1);
        $this->project->getFeatures()->remove(0);
        $this->assertEquals(0, count($this->project->getFeatures()));
    }

    public function testRemoveFeaturesByMethod()
    {
        $feature1 = $this->createFeature('Feature');
        $this->project->addFeature($feature1);
        $this->project->removeFeature($feature1);
        $this->assertEquals(0, count($this->project->getFeatures()));
    }

    private function setUpProject()
    {
        $this->project = new Project();
        $this->project->setName('Project 1');
        $this->project->setDescription('Any test');
    }

    /**
     * @param string $name
     *
     * @return Feature
     */
    private function createFeature(string $name): Feature
    {
        $feature1 = new Feature();
        $feature1->setName($name);
        return $feature1;
    }
}