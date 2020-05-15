<?php


namespace App\Tests\Core;

use App\Entity\Epic;
use App\Entity\Feature;
use App\Tests\CommonInitializer;

class EpicTest extends CommonInitializer
{
    public function testSimpleObject()
    {
        $epic = new Epic();
        $epic->setName('Epic');
        $epic->setDescription('Some description');

        $feature = new Feature();
        $epic->addFeature($feature);

        $this->assertSame('Epic', $epic->getName());
        $this->assertEmpty($epic->getId());
        $this->assertNotEmpty($epic->getFeatures());

        $epic->removeFeature($feature);
        $this->assertEmpty($epic->getFeatures());
    }

    public function testSimpleQuering()
    {
        $epic = $this->entityManager->getRepository(Epic::class)->findOneBy(['name' => 'Epic 1']);

        $this->assertNotEmpty($epic);
    }
}