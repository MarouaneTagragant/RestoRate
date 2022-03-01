<?php

namespace App\Fixtures;

use App\Entity\Review;
use App\Repository\RestaurantRepository;
use App\Repository\ReviewRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ReviewFixtures extends Fixture implements DependentFixtureInterface
{
    private $restaurantRepository;
    private $reviewRepository;
    private $userRepository;

    public function __construct(RestaurantRepository $restaurantRepository,
                                ReviewRepository $reviewRepository,
                                UserRepository $userRepository) {

        $this->restaurantRepository = $restaurantRepository;
        $this->reviewRepository = $reviewRepository;
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');
        for ($i=0; $i<100; $i++) {
            $review = new Review();
            $review->setMessage( $faker->text(800) );
            $review->setRating( rand(0,5) );
            $review->setRestaurant( $this->restaurantRepository->find(rand(1, 100)) );
            $review->setUser( $this->userRepository->findOneBy(["email" => "client@restorate.com"]) );
            $manager->persist($review);
        }
        $manager->flush();


        // les commenatire des reviews
        for ($i=0; $i<50; $i++) {
            $review = new Review();
            $managerOfRestaurant = array_rand(array('ROLE_MODERATEUR','ROLE_RESTAURATEUR'));

            $review->setMessage( $faker->text(500) );
            $review->setParent( $this->reviewRepository->find(rand(1, 100)) );
            $review->setRestaurant( $review->getParent()->getRestaurant() ); 
            $review->setUser( $this->userRepository->findOneBy(["roles" => $managerOfRestaurant]) );
            $manager->persist($review);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            RestaurantFixtures::class,
        );
    }
}