<?php


namespace App\Tests\Core;


use App\Entity\Feature;
use App\Entity\Project;
use App\Entity\User;
use App\Tests\CommonInitializer;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use TypeError;

class UserTest extends CommonInitializer
{
    public function testSimpleInitialization()
    {
        $user = new User();
        $user->setEmail('jairo@mail.com');
        $user->setPassword('1233');
        $user->setPlainPassword('1233');
        $user->setRoles(['ROLE_ADMIN']);

        $this->assertEmpty($user->getId());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->assertNotEquals('1233', $user->getPassword());
        $this->assertNotEquals($user->getPlainPassword(), $user->getPassword());
        $this->assertNotEmpty($user->getId());
        $this->assertSame('jairo@mail.com', $user->getEmail());
        $this->assertNotEmpty($user->getRoles());
        $this->assertNotEmpty($user->getUsername());
        $this->assertSame('jairo@mail.com', $user->getUsername());
        $this->assertNotEmpty($user->getPassword());
        $this->assertCount(2,  $user->getRoles());
    }

    public function testNotUpdatePassword()
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'new@mail.com']);
        $oldPassword = $user->getPassword();
        $user->setRoles(['ROLE_SUPER_ADMIN']);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->assertEquals($oldPassword, $user->getPassword());
        $this->assertEmpty($user->getPlainPassword());
    }

    public function testProjects()
    {
        $project = new Project();
        $user = new User();
        $user->addProject($project);
        $this->assertEquals(1, count($user->getProjects()));

        $user->removeProject($project);
        $this->assertEquals(0, count($user->getProjects()));
    }

    public function testUpgradePasswordOnly()
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'new@mail.com']);
        $oldPassword = $user->getPassword();
        $this->entityManager->getRepository(User::class)->upgradePassword($user, 'newpass');
        $this->assertNotEquals($oldPassword, $user->getPassword());
    }

    public function testHandleExceptionToUpgradePassword()
    {
        $this->expectException(TypeError::class);
        $user = $this->entityManager->getRepository(Feature::class)->findOneBy(['name' => 'Feature 1']);
        $this->entityManager->getRepository(User::class)->upgradePassword($user, 'newpass');
    }

    public function testHandleExceptionToUpgradePasswordUserFake()
    {

        $this->expectException(UnsupportedUserException::class);
        $user = new FakeUser();
        $this->entityManager->getRepository(User::class)->upgradePassword($user, 'newpass');
    }
}

class FakeUser implements UserInterface {

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        // TODO: Implement getRoles() method.
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}