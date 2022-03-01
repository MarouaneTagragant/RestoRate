<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Entity\Review;
use App\Form\RestaurantForm;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class RestaurantController extends AbstractController
{
    /**
     * Affiche la liste des restaurants
     * @Route("/restaurants", name="restaurant_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {

        $data = $this->getDoctrine()->getRepository(Restaurant::class)->findAll();

        $restaurants = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            50
        );

        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $restaurants,
        ]);
    }

    /**
     * Affiche la liste des restaurants
     * @Route("/myrestaurants", name="restaurants_index", methods={"GET"})
     */
    public function MyRestaurants(Request $request, PaginatorInterface $paginator)
    {
        $data = $this->getDoctrine()->getRepository(Restaurant::class)->findAll();

        $restaurants = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            50
        );

        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $restaurants,
        ]);
    }

    /**
     * Affiche un restaurant
     * @Route("/restaurant/{restaurant}", name="restaurant_show", methods={"GET"}, requirements={"restaurant"="\d+"})
     * @param Restaurant $restaurant
     * @return Response
     */
    public function show(Restaurant $restaurant)
    {
        return $this->render('restaurant/show.html.twig', [
            'restaurant' => $restaurant
        ]);
    }

    /**
     * Affiche et gère le formulaire de création de restaurant
     * @Route("/restaurant/new", name="restaurant_new", methods={"GET", "POST"})
     */
    public function new(Request $request)
    {
        $restaurant = new Restaurant();

        $form = $this->createForm(RestaurantForm::class, $restaurant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $restaurant = $form->getData();
            $restaurant->setUser($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($restaurant);
            $entityManager->flush();

            return $this->redirectToRoute('restaurant_index');
        }

        return $this->render('restaurant/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/search", name="app_search", methods={"GET"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function search(Request $request, PaginatorInterface $paginator) {

        $zipCode = $request->query->get('zipcode');
        $city = $this->getDoctrine()->getRepository(City::class)->findOneBy(["zipcode" => $zipCode]);

        if ($city) {
            $data = $city->getRestaurants();
            $restaurants = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                50
            );

            return $this->render('restaurant/index.html.twig', [
                'restaurants' => $restaurants,
            ]);
        }
        return $this->redirectToRoute("application_home");

    }


    /**
     * @Route("/", name="application_home", methods={"GET"})
     */
    public function home()
    {

        $tenRestaurants = $this->getDoctrine()->getRepository(Review::class)->findTenRestaurantByRatings();

        $tenBestRestaurants = array_map(function($data) {
            return $this->getDoctrine()->getRepository(Restaurant::class)->find($data['restaurantId']);
        }, $tenRestaurants);

        return $this->render('home/index.html.twig', [
            'restaurants' => $tenBestRestaurants,
        ]);
    }

    /**
     * Traite la requête d'un formulaire de création de restaurant
     * @Route("/restaurant", name="restaurant_create", methods={"POST"})
     */
    public function create()
    {
    }

    /**
     * Affiche le formulaire d'édition d'un restaurant (GET)
     * Traite le formulaire d'édition d'un restaurant (POST)
     * @Route("/restaurant/{restaurant}/edit", name="restaurant_edit", methods={"GET", "POST"})
     * @param Restaurant $restaurant
     */
    public function edit(Restaurant $restaurant)
    {
    }

    /**
     * Supprime un restaurant
     * @Route("/restaurant/{restaurant}", name="restaurant_delete", methods={"DELETE"})
     * @param Restaurant $restaurant
     */
    public function delete(Restaurant $restaurant)
    {
    }
}
