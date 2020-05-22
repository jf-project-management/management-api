<?php

namespace App\Tests\Core;

use App\Entity\Project;
use App\Entity\Team;
use App\Tests\CommonInitializer;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class TeamTest extends CommonInitializer
{
    public function testTeamData()
    {
        list($team, $project) = $this->createTeam();

        $this->assertGreaterThan(0, $project->getId());
        $this->assertGreaterThan(0, $team->getId());
        $this->assertEquals($project, $team->getProjects()->first());
    }

    public function testTeamRemoveProject()
    {
        list($team, $project) = $this->createTeam();

        $team->removeProject($project);
        $this->assertEquals(0, count($team->getProjects()));
    }

    public function testFindTeam()
    {
        $this->createTeam();

        $findTeam = $this->entityManager->getRepository(Team::class)->findOneBy(['name' => 'Team']);

        $this->assertNotEmpty($findTeam);
    }

    /**
     * @return array
     * @throws ORMException
     * @throws OptimisticLockException
     */
    private function createTeam(): array
    {
        $team = new Team();
        $team->setName('Team');
        $team->setDescription('');

        $project = new Project();
        $project->setName('Project 1');
        $project->setDescription('');

        $team->addProject($project);

        $this->entityManager->persist($project);
        $this->entityManager->persist($team);
        $this->entityManager->flush();
        return array($team, $project);
    }
}