<?php

namespace App\DataFixtures;

use App\Entity\Feature;
use App\Entity\History;
use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProjectFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $project = new Project();
        $project->setName('Project 1');
        $project->setDescription('');

        for ($x = 0; $x < 5; $x++) {
            $feature = new Feature();
            $feature->setName("Feature $x");
            $feature->setProject($project);
            $feature->setOrderPosition($x);
            $project->addFeature($feature);

            for($y = 0; $y < 6; $y++) {
                $history = new History();
                $history->setName("History $y");
                $history->setFeature($feature);
                $history->setOrderPosition($y);
                $manager->persist($history);
            }

            $manager->persist($feature);
        }

        $manager->persist($project);
        $manager->flush();
    }
}
