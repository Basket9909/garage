<?php

namespace App\Entity;



use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VoitureRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Voiture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=2, max=255, minMessage="La marque doit faire au moins 2 caractéres", maxMessage="Pas plus de 255 caractéres")
     */
    private $marque;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max=255, maxMessage="Pas plus de 255 caractéres")
     */
    private $modele;

    /**
     * @ORM\Column(type="float")
     * @Assert\Positive(message="Ce nombre doit être positif")
     */
    private $km;

    /**
     * @ORM\Column(type="float")
     * @Assert\Positive(message="Ce nombre doit être positif")
     */
    private $prix;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive(message="Ce nombre doit être positif")
     */
    private $proprietaire;

    /**
     * @ORM\Column(type="float")
     * @Assert\Positive(message="Ce nombre doit être positif")
     */
    private $cylindree;

    /**
     * @ORM\Column(type="float")
     * @Assert\Positive(message="Ce nombre doit être positif")
     */
    private $puissance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $carburant;

    /**
     * @ORM\Column(type="float")
     * @Assert\Length(4,exactMessage="Veuillez renseigner une année valable")
     */
    private $miseCirculation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $transmition;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=20, max=300, minMessage="Votre description doit faire plus de 20 caractères", maxMessage="Votre description doit faire moins de 300 caractéres")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=10, minMessage="Vos options doivent faire plus 10 caractères")
     */
    private $moreOption;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url()
     */
    private $coverImage;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="voiture", orphanRemoval=true)
     * @Assert\Valid()
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="cars")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    

    


    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * Permet d'initialiser le slug automatiquement
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function initializeSlug(){
        if(empty($this->slug)){
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->marque.'-'.$this->modele.'-'.$this->miseCirculation.'-'.rand(1,1000));
        }
    }

     /**
     * Permet d' avoir la marque et le modele de la voiture
     *
     * @return Response
     */
    public function getFullCar(){
        return "{$this->marque} {$this->modele}";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getKm(): ?float
    {
        return $this->km;
    }

    public function setKm(float $km): self
    {
        $this->km = $km;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getProprietaire(): ?int
    {
        return $this->proprietaire;
    }

    public function setProprietaire(int $proprietaire): self
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    public function getCylindree(): ?float
    {
        return $this->cylindree;
    }

    public function setCylindree(float $cylindree): self
    {
        $this->cylindree = $cylindree;

        return $this;
    }

    public function getPuissance(): ?float
    {
        return $this->puissance;
    }

    public function setPuissance(float $puissance): self
    {
        $this->puissance = $puissance;

        return $this;
    }

    public function getCarburant(): ?string
    {
        return $this->carburant;
    }

    public function setCarburant(string $carburant): self
    {
        $this->carburant = $carburant;

        return $this;
    }

    public function getMiseCirculation(): ?float
    {
        return $this->miseCirculation;
    }

    public function setMiseCirculation(float $miseCirculation): self
    {
        $this->miseCirculation = $miseCirculation;

        return $this;
    }

    public function getTransmition(): ?string
    {
        return $this->transmition;
    }

    public function setTransmition(string $transmition): self
    {
        $this->transmition = $transmition;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMoreOption(): ?string
    {
        return $this->moreOption;
    }

    public function setMoreOption(string $moreOption): self
    {
        $this->moreOption = $moreOption;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setVoiture($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getVoiture() === $this) {
                $image->setVoiture(null);
            }
        }

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
