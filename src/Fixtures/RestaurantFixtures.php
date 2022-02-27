<?php

namespace App\Fixtures;

use App\Entity\Restaurant;
use App\Repository\CityRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RestaurantFixtures extends Fixture implements DependentFixtureInterface
{
    private $cityRepository;
    private $userRepository;

    public  function __construct(CityRepository $cityRepository, UserRepository $userRepository) {
        $this->cityRepository = $cityRepository;
        $this->userRepository = $userRepository;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i=0; $i < 1000; $i++) {

            $restaurant = new Restaurant();
            $restaurant->setName( $faker->company );
            $restaurant->setDescription( $faker->text(500) );
            // $restaurant->setCity( $this->cityRepository->find( rand(1, 1000) ) );
            // $restaurant->setUser( $this->userRepository->findOneBy(["email" => "restaurateur@restorate.com"]) );

            $manager->persist($restaurant);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class
        );
    }
}
