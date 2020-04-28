<?php

use App\Entity\Project;
use App\Tests\CommonInitializer;

class ProjectRepositoryTest extends CommonInitializer
{
    public function testSearchByName()
    {
        $name = "Project 1";
        $project = $this->entityManager
            ->getRepository(Project::class)
            ->findOneBy(['name' => $name]);

        $this->assertSame($name, $project->getName());
    }
}