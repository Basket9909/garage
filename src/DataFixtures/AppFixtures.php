<?php

namespace App\DataFixtures;

use App\Vehicle;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Voiture;
use Cocur\Slugify\Slugify;
use Faker\Provider\Fakecar;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{

        // gestion du hash du password
        private $passwordHasher;

        public function __construct(UserPasswordHasherInterface $passwordHasher)
        {
            $this->passwordHasher = $passwordHasher;
        }

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');
        $slugify = new slugify();

        //gestion des utilisateur 
        $users = [];
        $genres = ['male','femelle'];

       /* for($u = 1; $u <= 10; $u++)
        {
            $user = new User();
            $genre = $faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1,99).'.jpg';
            $picture .= ($genre =='male' ? 'men/' : 'women/').$pictureId;

            $hash = $this->passwordHasher->hashPassword($user,'password');

            $user->setFirstName($faker->firstName($genre))
                ->setLastName($faker->lastName())
                ->setEmail($faker->email())
                ->setDescription('<p>'.join('</p><p>',$faker->paragraphs(3)).'</p>')
                ->setPassword($hash)
                ->setPicture($picture);

            $manager->persist($user);
            $users[] = $user; // ajouter l'utilisateur au tableau pour les annonces    
        }*/

        
        $typeTransmition = ['avant','arriére','integrale'];
        $tabMarque = ['Audi','Alfa Romeo','BMW','Volswagen','Renault','Citroën','Ford'];
        $modeleAudi = ['A1','A4','TT','A5','A6'];
        $modeleAlfa = ['Giulia','Giulietta','Stelvio','Gtv','Brera'];
        $modeleBmw = ['I3','I4','I8','Serie 1','Serie 2'];
        $modeleVw = ['Caddy','California','Golf','Arteon','Crafter'];
        $modeleRenault = ['Clio','Twingo','Megane','Espace','Kadjar'];
        $modeleCitroen = ['C2','C3','C4','Berlingo','C5'];
        $modeleFord = ['Fiesta','Focus','Galaxy','Kuga','Ka'];
        $carburants = ['Essence','Diesel','Lpg'];
 
        for($i = 1; $i <= 30 ; $i++)
        {
            $car = new Voiture();
            $marque = $faker->randomElement($tabMarque);
            if($marque === 'Audi')
            {
                $modele = $faker->randomElement($modeleAudi);
            }
            else if($marque ==='Alfa Romeo')
            {
                $modele = $faker->randomElement($modeleAlfa);
            }
            else if($marque ==='BMW')
            {
                $modele = $faker->randomElement($modeleBmw);
            }
            else if($marque ==='Volswagen')
            {
                $modele = $faker->randomElement($modeleVw);
            }
            else if($marque ==='Renault')
            {
                $modele = $faker->randomElement($modeleRenault);
            }
            else if($marque ==='Citroën')
            {
                $modele = $faker->randomElement($modeleCitroen);
            }else{
                $modele = $faker->randomElement($modeleFord);
            }
            $carbu = $faker->randomElement($carburants);
            $year = $faker->biasedNumberBetween(1995,2015);
            $transmition = $faker->randomElement($typeTransmition);
            $description = $faker->paragraph(2);
            $option = '<p>'.join('</p><p>',$faker->paragraphs(5)).'</p>';

            // liaison avec user
            //$user = $users[rand(0, count($users)-1)];

            $car->setMarque($marque)
                ->setSlug($marque.'-'.$modele.'-'.$year.'-'.rand(1,10000))
                ->setModele($modele)
                ->setKm(rand(5000,10000))
                ->setPrix(rand(5000,50000))
                ->setProprietaire(rand(1,5))
                ->setCylindree(rand(90,900))
                ->setPuissance(rand(90,900))
                ->setCarburant($carbu)
                ->setMiseCirculation($year)
                ->setTransmition($transmition)
                ->setDescription($description)
                ->setMoreOption($option)
                ->setCoverImage('https://picsum.photos/id/'.rand(1,700).'//500/500');
                //->setAuthor($user);

            $manager->persist($car);

            for($j=1 ; $j<=rand(2,5) ; $j++)
            {
                $image = new Image;
                $image->setUrl('https://picsum.photos/id/'.rand(1,700).'//500/500')
                      ->setCaption($faker->sentence())
                      ->setVoiture($car);

                $manager->persist($image);

            }
        }
        $manager->flush();
    }
   
}

