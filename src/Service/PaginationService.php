<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;


class PaginationService{

    /**
     * Entité sur laquelle paginer
     *
     * @var [string]
     */
    private $entityClass;

    /**
     * Le nombre délément à récupérer
     *
     * @var integer
     */
    private $limit = 10;

    /**
     * La page sur laquelle on se trouve
     *
     * @var integer
     */
    private $currentPage = 1;

    /**
     * Le manager de doctrine pour trouver le repository
     *
     * @var EntityManagerInterface
     */
    private $manager;


    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Spécifier l'entité à paginer
     *
     * @param [string] $entityClass
     * @return self
     */
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;

        return $this;
    }

    /**
     * récuperer l'entité sur laqulle on pagine
     *
     * @return void
     */
    public function getEntityClass(){
        return $this->entityClass;
    }

    /**
     * Spécifier la limite d'élément à afficher
     *
     * @param int $limit
     * @return self
     */
    public function setLimit($limit){
        $this->limit = $limit;
        return $this;
    }

    /**
     * Récuperer le nombre d'élément qu'on affiche
     *
     * @return void
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Spécifier la page que l'on veut afficher
     *
     * @param int $page
     * @return self
     */
    public function setPage($page){
        $this->currentPage = $page;
        return $this;
    }

    /**
     * Récuperer la page sur laquelle on est
     *
     * @return void
     */
    public function getPage()
    {
        return $this->currentPage;
    }

    /**
     * Récupere les donnée de la pagination
     *
     * @return void
     */
    public function getData()
    {
        // calculer l'offset
        $offset = $this->currentPage * $this->limit - $this->limit;
        // demander au repository de trouver les éléments 
        $repo = $this->manager->getRepository($this->entityClass);
        $data = $repo->findBy([],[],$this->limit,$offset);

        // renvoyer les données
        return $data;

    }

    /**
     * Récuperer le nombre de page totale sur une entitée
     *
     * @return void
     */
    public function getPages()
    {
        // conntaire le total des enregirstement de la tablez
        $repo = $this->manager->getRepository($this->entityClass);
        $total = count($repo->findAll());
        // 3.1 => 4 
        $pages = ceil($total / $this->limit);

        return $pages;
    }


} 