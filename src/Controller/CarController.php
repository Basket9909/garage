<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\CarType;
use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * Permet de créer une annonce
     * @Route("/cars/new", name="cars_create")
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $manager){

        $car = new Voiture();

         
       
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            foreach($car->getImages() as $image){
                $image->setVoiture($car);
                $manager->persist($image);
            }
            $manager->persist($car);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong>{$car->getFullCar()}</strong> a bien été enregistrée! "
            );
   
            return $this->redirectToRoute('cars_show',[
                'slug' => $car->getSlug()
            ]);

        }



        return $this->render("car/new.html.twig",[
            'myForm' => $form->createView()
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


