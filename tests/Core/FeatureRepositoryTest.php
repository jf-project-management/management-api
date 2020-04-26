<?php

use App\Entity\Feature;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FeatureRepositoryTest extends KernelTestCase
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testSearchByName()
    {
        $name = "Feature 1";
        $project = $this->entityManager
            ->getRepository(Feature::class)
            ->findOneBy(['name' => $name]);

        $this->assertSame($name, $project->getName());
    }

    public function testGetFeaturesPendingByOrder()
    {
        $initialPosition = 1;
        $newPosition = 3;
        $pending = $this->entityManager->getRepository(Feature::class)->getFeaturesPendingByOrder(3);
        dump($pending);
        return null;
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}