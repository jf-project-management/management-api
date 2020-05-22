<?php


namespace App\Tests\Core;


use App\Entity\Company;
use App\Entity\Team;
use App\Entity\User;
use App\Tests\CommonInitializer;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class companyTest extends CommonInitializer
{
    public function testCompany()
    {
        list($user, $company, $team) = $this->setInfo();

        $this->assertGreaterThan(0, $company->getId());
        $this->assertEquals('Company INC', $company->getName());
        $this->assertEquals($user, $company->getCreatedBy());
        $this->assertEquals(0, $company->getOrderPosition());
        $this->assertEquals($team, $company->getTeams()->first());

        $companyFound = $this->entityManager->getRepository(Company::class)->findOneBy(['name' => 'Company INC']);

        $this->assertNotEmpty($companyFound);
    }

    public function testCompanyRemove()
    {
        list($user, $company, $team) = $this->setInfo();

        $company->removeTeam($team);
        $this->entityManager->persist($company);
        $this->entityManager->flush();

        $this->assertEquals(0, count($company->getTeams()));
    }

    /**
     * @return array
     * @throws ORMException
     * @throws OptimisticLockException
     */
    private function setInfo(): array
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'pepito_demo@mail.com']);

        $company = new Company();
        $company->setCreatedBy($user);
        $company->setName('Company INC');
        $company->setDescription('.....');

        $team = new Team();
        $team->setName('Team 1 company INC');
        $team->setDescription('');
        $this->entityManager->persist($team);
        $company->addTeam($team);

        $this->entityManager->persist($company);
        $this->entityManager->flush();
        return array($user, $company, $team);
    }
}