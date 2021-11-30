<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Faker\Factory;
use App\Vehicle;
use Faker\Provider\Fakecar;
use App\Entity\Voiture;
use Cocur\Slugify\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');
        $slugify = new slugify();
        $typeTransmition = ['avant','arriére','integrale'];

        for($i = 1; $i <= 30 ; $i++)
        {
            $car = new Voiture();
            //$marque = $faker->vehicleBrand();
            //$slug = $slugify->slugify($marque);
            //$modele = $faker->vehicleModel();
            //$carburant = $faker->vehicleFuelType();
            $year = $faker->biasedNumberBetween(1995,2015);
            $transmition = $faker->randomElement($typeTransmition);
            $description = $faker->paragraph(2);
            $option = '<p>'.join('</p><p>',$faker->paragraphs(5)).'</p>';

            $car->setMarque('Ford')
                ->setSlug('Ford-'.rand(1,100000))
                ->setModele('Fiesta')
                ->setKm(rand(1000,10000))
                ->setPrix(rand(5000,50000))
                ->setProprietaire(rand(1,5))
                ->setCylindree(rand(90,900))
                ->setPuissance(rand(90,900))
                ->setCarburant('Diesel')
                ->setMiseCirculation($year)
                ->setTransmition($transmition)
                ->setDescription($description)
                ->setMoreOption($option)
                ->setCoverImage('https://picsum.photos/500/500');

            $manager->persist($car);

            for($j=1 ; $j<=rand(2,5) ; $j++)
            {
                $image = new Image;
                $image->setUrl('https://picsum.photos/500/500')
                      ->setCaption($faker->sentence())
                      ->setVoiture($car);

                $manager->persist($image);

            }
        }
        $manager->flush();
    }
   
}

