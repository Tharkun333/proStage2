<?php

namespace App\Entity;

use App\Repository\StageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=StageRepository::class)
 */
class Stage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide")
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide")
     */
    private $missions;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide")
     */
    private $contact;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="stages")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid
     */
    private $codeEntreprise;

    /**
     * @ORM\ManyToMany(targetEntity=Formation::class, inversedBy="stages")
     * @Assert\Count(min=1, minMessage ="Il faut au moins une formation")
     * @Assert\Valid
     */
    private $codeFormation;

    public function __construct()
    {
        $this->codeFormation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getMissions(): ?string
    {
        return $this->missions;
    }

    public function setMissions(string $missions): self
    {
        $this->missions = $missions;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getCodeEntreprise(): ?Entreprise
    {
        return $this->codeEntreprise;
    }

    public function setCodeEntreprise(?Entreprise $codeEntreprise): self
    {
        $this->codeEntreprise = $codeEntreprise;

        return $this;
    }

    /**
     * @return Collection|Formation[]
     */
    public function getCodeFormation(): Collection
    {
        return $this->codeFormation;
    }

    public function addCodeFormation(Formation $codeFormation): self
    {
        if (!$this->codeFormation->contains($codeFormation)) {
            $this->codeFormation[] = $codeFormation;
        }

        return $this;
    }

    public function removeCodeFormation(Formation $codeFormation): self
    {
        $this->codeFormation->removeElement($codeFormation);

        return $this;
    }
}
