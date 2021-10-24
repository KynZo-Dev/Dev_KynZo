<?php

namespace App\Entity;

use App\Repository\ProjetsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjetsRepository::class)
 */
class Projets
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $Titre;

    /**
     * @ORM\Column(type="text")
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ImgProjet;

    /**
     * @ORM\Column(type="integer")
     */
    private $Progress;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): self
    {
        $this->Titre = $Titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getImgProjet(): ?string
    {
        return $this->ImgProjet;
    }

    public function setImgProjet(?string $ImgProjet): self
    {
        $this->ImgProjet = $ImgProjet;

        return $this;
    }

    public function getProgress(): ?int
    {
        return $this->Progress;
    }

    public function setProgress(int $Progress): self
    {
        $this->Progress = $Progress;

        return $this;
    }
}
