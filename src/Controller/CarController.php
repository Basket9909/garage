<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\CarType;
use App\Entity\Voiture;
use App\Service\PaginationService;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\When;

class CarController extends AbstractController
{
    /**
     * Permet d'avoir toutes les annonces
     * @Route("/cars/{page<\d+>?1}", name="cars_index")
     * @param VoitureRepository $repo
     * @return Response
     */
    public function index(PaginationService $pagination, $page): Response
    {
        $pagination->setEntityClass(Voiture::class)
                    ->setPage($page)
                    ->setLimit(12);

        //$cars = $repo->findAll();

        return $this->render('car/index.html.twig', [
            'pagination' => $pagination
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


