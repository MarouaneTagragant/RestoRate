<?php

namespace App\Fixtures;

use App\Entity\User;
use App\Repository\CityRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use faker\Factory;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;
    private $cityRepository;

    public function __construct(UserPasswordEncoderInterface $encoder, CityRepository $cityRepository)
    {
        $this->encoder = $encoder;
        $this->cityRepository = $cityRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $city = $this->cityRepository->find(rand(1, 1000));

        $userAdmin = new User();
        $userAdmin->setEmail('moderateur@restorate.com');
        $userAdmin->setFirstName($faker->firstNameMale);
        $userAdmin->setLastName($faker->lastName);
        $userAdmin->setPassword($this->encoder->encodePassword($userAdmin, '123456789'));
        $userAdmin->setRoles(['ROLE_ADMIN']);
        $userAdmin->setCity($city);
        $manager->persist($userAdmin);

        $userClient = new User();
        $userClient->setEmail('client@restorate.com');
        $userClient->setFirstName($faker->firstNameMale);
        $userClient->setLastName($faker->lastName);
        $userClient->setPassword($this->encoder->encodePassword($userClient, '123456789'));
        $userClient->setRoles(['ROLE_CLIENT']);
        $userClient->setCity($city);
        $manager->persist($userClient);

        $userRestaurateur = new User();
        $userRestaurateur->setEmail('restaurateur@restorate.com');
        $userRestaurateur->setPassword($this->encoder->encodePassword($userRestaurateur, '123456789'));
        $userRestaurateur->setRoles(['ROLE_RESTAURATEUR']);
        $userRestaurateur->setCity($city);
        $manager->persist($userRestaurateur);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CityFixtures::class,
        );
    }
}
