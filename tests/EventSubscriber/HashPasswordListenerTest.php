<?php

namespace App\Tests\EventSubscriber;

use App\Doctrine\HashPasswordListener;
use App\Entity\User;
use App\Tests\CommonInitializer;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class HashPasswordListenerTest extends CommonInitializer
{
    protected static $factoryFake;
    protected static $encoderFake;
    protected static $hashPasswordListener;

    public static function setUpBeforeClass()
    {
        self::$factoryFake = new EncoderFactoryMock();
        self::$encoderFake = new UserPasswordEncoderMock(self::$factoryFake);
        self::$hashPasswordListener = new HashPasswordListener(self::$encoderFake);
    }

    public function testConfiguration()
    {
        $this->assertEquals(['prePersist', 'preUpdate'], self::$hashPasswordListener->getSubscribedEvents());
    }

    public function testPersist()
    {
        $object = new MockUser();

        $args = new LifecycleEventArgs($object, $this->entityManager);
        $result = self::$hashPasswordListener->prePersist($args);

        $this->assertEquals($result, null);

        $args = new LifecycleEventArgs(new User(), $this->entityManager);
        $result = self::$hashPasswordListener->prePersist($args);

        $this->assertEquals($result, []);
    }
}

class MockUser
{

}

class UserPasswordEncoderMock extends UserPasswordEncoder
{

}

class EncoderFactoryMock implements EncoderFactoryInterface{

    /**
     * @inheritDoc
     */
    public function getEncoder($user)
    {
        // TODO: Implement getEncoder() method.
    }
}