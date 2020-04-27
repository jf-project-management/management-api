<?php

use App\Entity\Feature;
use App\Utils\Utils;
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

    public function testReorderElements()
    {
        $feature = $this->entityManager->getRepository(Feature::class)->findOneBy(['name' => 'Feature 2']);
        $this->assertEquals(2, $feature->getOrderPosition());
        Utils::reOrderItems($feature, 4, $this->entityManager);
        $this->assertEquals(4, $feature->getOrderPosition());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}