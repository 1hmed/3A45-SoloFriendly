<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 * @UniqueEntity("nom")
 */
class Evenement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThanOrEqual(
     *      value = "today"
     * )
     */
    private $datedeb;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThanOrEqual(
     *      value = "today"
     * )
     * @Assert\Expression(
     *     "this.getDatefin() >= this.getDatedeb()",
     *     message="Verifier votre date"
     * )
     */
    private $datefin;


    /**
     * @ORM\Column(type="string", length=255)

     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="evenement")
     */
    private $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="evenements")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Destination::class, mappedBy="evenement")
     */
    private $destination;

    /**
     * @ORM\ManyToMany(targetEntity=Planning::class, inversedBy="evenements")
     */
    private $planning;

    /**
     * @ORM\ManyToOne(targetEntity=Actualite::class, inversedBy="evenements")
     */
    private $actualite;

    public function __construct()
    {
        $this->destination = new ArrayCollection();
        $this->planning = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

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

    public function getDatedeb(): ?\DateTimeInterface
    {
        return $this->datedeb;
    }

    public function setDatedeb(\DateTimeInterface $datedeb): self
    {
        $this->datedeb = $datedeb;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
    }



    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
    public function setPicture(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|Destination[]
     */
    public function getDestination(): Collection
    {
        return $this->destination;
    }

    public function addDestination(Destination $destination): self
    {
        if (!$this->destination->contains($destination)) {
            $this->destination[] = $destination;
            $destination->setEvenement($this);
        }

        return $this;
    }

    public function removeDestination(Destination $destination): self
    {
        if ($this->destination->removeElement($destination)) {
            // set the owning side to null (unless already changed)
            if ($destination->getEvenement() === $this) {
                $destination->setEvenement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Planning[]
     */
    public function getPlanning(): Collection
    {
        return $this->planning;
    }

    public function addPlanning(Planning $planning): self
    {
        if (!$this->planning->contains($planning)) {
            $this->planning[] = $planning;
        }

        return $this;
    }

    public function removePlanning(Planning $planning): self
    {
        $this->planning->removeElement($planning);

        return $this;
    }

    public function getActualite(): ?Actualite
    {
        return $this->actualite;
    }

    public function setActualite(?Actualite $actualite): self
    {
        $this->actualite = $actualite;

        return $this;
    }
}
