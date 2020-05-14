<?php

namespace App\DataFixtures;

use App\Entity\Epic;
use App\Entity\Feature;
use App\Entity\History;
use App\Entity\Project;
use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * @codeCoverageIgnore
 */
class ProjectFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $project = new Project();
        $project->setName('Project 1');
        $project->setDescription('');

        for($d = 0; $d < 5; $d++) {
            $epic = new Epic();
            $epic->setOrderPosition($d);
            $epic->setName("Epic $d");
            $epic->setDescription('Any description $d');

            for ($x = 0; $x < 5; $x++) {
                $feature = new Feature();
                $feature->setEpic($epic);
                $feature->setName("Feature $x");
                $feature->setOrderPosition($x);

                for($y = 0; $y < 6; $y++) {
                    $history = new History();
                    $history->setName("History $y");
                    $history->setFeature($feature);
                    $history->setOrderPosition($y);
                    $manager->persist($history);

                    for($z = 0; $z < 6; $z++) {
                        $task = new Task();
                        $task->setName("Task $z");
                        $task->setDescription('');
                        $task->setHistory($history);
                        $task->setOrderPosition($z);
                        $manager->persist($task);
                    }
                }

                $manager->persist($feature);

            }

            $manager->persist($epic);
        }

        $manager->persist($project);
        $manager->flush();
    }
}
