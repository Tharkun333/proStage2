<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 */
class Entreprise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(min=4,minMessage=" Doit faire plus de 4 caractères")
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(pattern="#^([1-9][0-9]?[0-9]? ?(bis)? )#i",message="Le numéro de rue semble incorrect (ca marche pas)")
     * @Assert\Regex(pattern="# (rue|avenue|boulevard|impasse|allée|place|route) #i",message="Le type de route/voie semble incorrect")
     * @Assert\Regex(pattern="# [0-9]{5} #i",message="Il semble y avoir un problème avec le code postal")
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide")
     */
    private $activite;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide")
     * @Assert\Url
     */
    private $urlSite;

    /**
     * @ORM\OneToMany(targetEntity=Stage::class, mappedBy="codeEntreprise", orphanRemoval=true)
     */
    private $stages;

    public function __construct()
    {
        $this->stages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(string $activite): self
    {
        $this->activite = $activite;

        return $this;
    }

    public function getUrlSite(): ?string
    {
        return $this->urlSite;
    }

    public function setUrlSite(string $urlSite): self
    {
        $this->urlSite = $urlSite;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->setCodeEntreprise($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getCodeEntreprise() === $this) {
                $stage->setCodeEntreprise(null);
            }
        }

        return $this;
    }
    
    
    public function __toString()
    {
        return $this->getNom();
    }
}
