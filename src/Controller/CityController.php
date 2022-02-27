<?php

namespace App\Controller;

use App\Entity\City;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CityController extends AbstractController
{
    /**
     * Affiche la liste de toutes les cities
     * @Route("/cities", name="city_index")
     */
    public function index()
    {
        $data = $this->getDoctrine()->getRepository(City::class)->findAll();
        $restaurants = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            50
        );
    }

    /**
     * Affiche le détail d'une city
     * @Route("/city/{city}", name="city_show", methods={"GET"}, requirements={"city"="\d+"})
     * @param City $city
     */
    public function show(City $city)
    {
    }

    /**
     * Traite la requête d'un formulaire de création de city
     * @Route("/city", name="city_create", methods={"POST"})
     */
    public function create()
    {
    }

    /**
     * Affiche le formulaire d'édition d'une city (GET)
     * Traite le formulaire d'édition d'une city (POST)
     * @Route("/city/{city}/edit", name="city_edit", methods={"GET", "POST"})
     * @param City $city
     */
    public function edit(City $city)
    {
    }

    /**
     * Supprime une city
     * @Route("/city/{city}", name="city_delete", methods={"DELETE"})
     * @param City $city
     */
    public function delete(City $city)
    {
    }
}
