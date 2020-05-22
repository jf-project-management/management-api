<?php

namespace App\Tests\Core;

use App\Entity\Epic;
use App\Entity\Project;
use App\Entity\User;
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
        $this->assertNotEmpty($this->project->getCreatedBy());
    }

    public function testProjectEpics()
    {
        $epic1 = $this->createEpic('Epic 1');
        $epic2 = $this->createEpic('Epic 2');

        $this->project->addEpic($epic1);
        $this->project->addEpic($epic2);

        $this->assertInstanceOf(Epic::class, $epic1);
        $this->assertNotEmpty($this->project->getEpics());
        $this->assertEquals(2, count($this->project->getEpics()));
    }

    public function testRemoveEpicsByIndex()
    {
        $epic1 = $this->createEpic('Epic');
        $this->project->addEpic($epic1);
        $this->project->getEpics()->remove(0);
        $this->assertEquals(0, count($this->project->getEpics()));
    }

    public function testRemoveEpicsByMethod()
    {
        $epic1 = $this->createEpic('Epic');
        $this->project->addEpic($epic1);
        $this->project->removeEpic($epic1);
        $this->assertEquals(0, count($this->project->getEpics()));
    }

    private function setUpProject()
    {
        $user = new User();
        $this->project = new Project();
        $this->project->setName('Project 1');
        $this->project->setDescription('Any test');
        $this->project->setCreatedBy($user);
    }

    /**
     * @param string $name
     *
     * @return Epic
     */
    private function createEpic(string $name): Epic
    {
        $epic1 = new Epic();
        $epic1->setName($name);
        return $epic1;
    }
}