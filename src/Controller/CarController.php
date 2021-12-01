<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    /**
     * @Route("/cars", name="cars_index")
     */
    public function index(VoitureRepository $repo): Response
    {

        $cars = $repo->findAll();

        return $this->render('car/index.html.twig', [
            'cars' => $cars
        ]);
    }


    /**
     * Permet d'afficher une seule voiture
     * @Route("/cars/{slug}", name="cars_show")
     * @return Response
     */
    public function show($slug, Voiture $voiture)
    {
        return $this->render('car/show.html.twig',[
            'car' => $voiture
        ]);
    }
}


