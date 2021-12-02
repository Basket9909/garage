<?php

namespace App\Form;

use App\Entity\Voiture;
use App\Form\ImageType;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class CarType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('marque',TextType::class,$this->getConfiguration("Marque","Donner la marque de la voiture"))
            ->add('modele',TextType::class,$this->getConfiguration("Modéle","Donner le modéle de la voiture"))
            ->add('km', IntegerType::class,$this->getConfiguration("Nombre de kilométre","Donner le nombre de kilométre déja roulé"))
            ->add('prix', MoneyType::class, $this->getConfiguration("Prix","Donner le rpix de la voiture"))
            ->add('proprietaire', IntegerType::class,$this->getConfiguration("Nombre de propriétaire","Donner le nombre de propriétaire"))
            ->add('cylindree',IntegerType::class,$this->getConfiguration("Nombre de cylindre","Donner le nombre de cylindre de la voiture"))
            ->add('puissance',IntegerType::class,$this->getConfiguration("Nombre de chevaux","Donner le nombre de chevaux de la voiture"))
            ->add('carburant',TextType::class,$this->getConfiguration("Carburant","Donner le tyoe de carburant de la voiture"))
            ->add('miseCirculation',IntegerType::class,$this->getConfiguration("Date de mise en circulation","Donner la date de la mise en circulation de la voiture"))
            ->add('transmition',TextType::class,$this->getConfiguration("Transmition","Donner le type de transmition de la voiture"))
            ->add('description',TextType::class,$this->getConfiguration("Description","Donner une courte description de la voiture"))
            ->add('moreOption',TextareaType::class,$this->getConfiguration("Option(s)","Donner le(s) otpion(s) supplémentaire"))
            ->add('coverImage',UrlType::class,$this->getConfiguration("Url de l'image","Donner l'url de l'image"))
            ->add('images',
            CollectionType::class,
            [
                'entry_type' => ImageType::class,
                'allow_add' => true, // permet d'ajouter des élément et surtout avoir le data_protoype
                'allow_delete' => true
            ]

        )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
