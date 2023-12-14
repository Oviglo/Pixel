<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    #[ORM\Column(length: 80)]
    private ?string $name = null;

    #[Assert\Image(maxSize: '3M')]
    private ?UploadedFile $file = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    public function setFile(?UploadedFile $file): self
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Génération d'un nom de fichier pour éviter les doublons
     */
    public function generatePath(): self
    {
        // Si un fichier a bien été envoyé
        if ($this->file instanceof UploadedFile) {
            // Génére un chemin
            // $this->path = uniqid('img_');
            $this->path = time(); 
            // Récupére le nom du fichier envoyé
            $this->name = $this->file->getClientOriginalName();
        }

        return $this;
    }

    /**
     * Retourne le lien absolu vers le dossier d'upload
     */
    public static function getPublicRootDir(): string
    {
        return __DIR__.'/../../public/images/';
    }
    
    public function upload(): void
    {
        if ($this->file instanceof UploadedFile) {
            // Déplace le fichier temp de l'image vers le dossier public/images
            $this->file->move(self::getPublicRootDir(), $this->path);
        }
    }
}
