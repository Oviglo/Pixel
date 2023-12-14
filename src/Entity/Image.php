<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
#[ORM\HasLifecycleCallbacks]
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

    private ?string $oldPath = null;

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

        $this->oldPath = $this->path; // Sauvegarde le chemin de l'ancien fichier pour le supprimer lors de l'upload du nouveau
        $this->path = ""; // Modifier cette valeur pour forcer Doctrine à modifier l'entité

        return $this;
    }

    /**
     * Génération d'un nom de fichier pour éviter les doublons
     */
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function generatePath(): self
    {
        // Si un fichier a bien été envoyé
        if ($this->file instanceof UploadedFile) {
            // Génére un chemin
            // $this->path = uniqid('img_');
            $this->path = time().'.'.$this->file->guessClientExtension(); 
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
    
    #[ORM\PostPersist]
    #[ORM\PostUpdate]
    public function upload(): void
    {
        // Supprimer l'ancien fichier
        if (is_file(self::getPublicRootDir().$this->oldPath)) {
            unlink(self::getPublicRootDir().$this->oldPath);
        }

        if ($this->file instanceof UploadedFile) {
            // Déplace le fichier temp de l'image vers le dossier public/images
            $this->file->move(self::getPublicRootDir(), $this->path);
        }
    }

    public function getWebPath(): string
    {
        return '/images/'.$this->path;
    }

    public function __toString(): string
    {
        return $this->getWebPath();
    }

    // Supprime le fichier après le remove en DB
    #[ORM\PreRemove]
    public function removeFile(): void
    {
        if (is_file(self::getPublicRootDir().$this->path)) {
            unlink(self::getPublicRootDir().$this->path);
        }
    }
}
