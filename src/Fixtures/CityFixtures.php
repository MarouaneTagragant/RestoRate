<?php

namespace App\Fixtures;

use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 200; $i++) {
            $city = new City();
            $city->setName( $faker->city );
            $city->setZipcode( $faker->postcode );

            $manager->persist($city);
        }

        $manager->flush();
    }
}