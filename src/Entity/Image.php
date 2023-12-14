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

    #[ORM\Column(length: 80)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    #[Assert\Image(maxSize: '3M')]
    private ?UploadedFile $file = null;

    private ?string $oldPath = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    public function setFile(?UploadedFile $file): self
    {
        $this->file = $file;

        $this->oldPath = $this->path; // Copie le chemin de l'ancien fichier pour le supprimer plus tard
        $this->path = ""; // Modifier path pour forcer l'update de la db ET l'upload

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
            // $this->path = uniqid('img_'); // Génére un nom 'img_3135432138'
            $this->path = time() . '_img' . '.' . $this->file->guessClientExtension();
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
        // Supprime l'ancien fichier
        $old = self::getPublicRootDir().$this->oldPath;
        if (is_file($old)) {
            unlink($old);
        }

        if ($this->file instanceof UploadedFile) {
            // Déplace le fichier uploadé vers le bon dossier et le renome (path)
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

    // Supprime le fichier avant de supprimer dans la db
    #[ORM\PreRemove]
    public function removeFile(): void
    {
        $path = self::getPublicRootDir().$this->path;
        if (is_file($path)) {
            unlink($path);
        }
    }
}
