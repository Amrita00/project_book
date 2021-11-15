<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordHasherInterface
     */
    private $hasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->hasher = $passwordHasher;
    }
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $this->addAdmin($manager);

        $manager->flush();
    }
    public function addAdmin($manager)
    {
        $admin = new User();
        $admin->setFirstname('Chandesh');
        $admin->setLastname('Lillmond');
        $admin->setUsername('admin');
        $admin->setPassword(
            $this->hasher->hashPassword(
                $admin,
                'admin123'
            )
        );
        $admin->setRoles([
            'ROLE_ADMIN'
        ]);

        $manager->persist($admin);
    }


}
