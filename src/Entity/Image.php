<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 * 
 * Indique que l'entité a un cycle de vie (événements Doctrine)
 * @ORM\HasLifecycleCallbacks
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $name;

    /**
     * @var UploadedFile
     * 
     * @Assert\Image(
     *  maxSize = "3M"
     * )
     */
    private $file;

    /**
     * @var ?string
     * Chemin de l'ancien fichier pour pouvoir le supprimer
     */
    private $oldPath;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of file
     */ 
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set the value of file
     *
     * @return  self
     */ 
    public function setFile($file)
    {
        $this->file = $file;
        $this->oldPath = $this->path; // Sauvegarde le chemin de l'ancien fichier pour le supprimer lors de l'upload du nouveau
        $this->path = ""; // Modifie cette valeur pour activer la modification par Doctrine

        return $this;
    }

    /**
     * Retourne le lien vers le dossier d'upload
     */
    public function getPublicRootDir(): string
    {
        return __DIR__ . '/../../public/uploads/';
    }

    /**
     * Génération d'un nom de fichier (pour éviter les doublons)
     * 
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function generatePath(): void 
    {
        // Si un fichier a été envoyé
        if ($this->file instanceof UploadedFile) {
            // Génére un chemin de fichier
            $this->path = uniqid('img_').'.'.$this->file->guessExtension();
        }
    }

    /**
     * Déplace le fichier du dossier temp vers le dossier upload
     * 
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload(): void
    {
        // Supprimer l'ancien fichier
        if (is_file($this->getPublicRootDir().$this->oldPath)) {
            unlink($this->getPublicRootDir().$this->oldPath);
        }

        if ($this->file instanceof UploadedFile) {
            $this->file->move($this->getPublicRootDir(), $this->path);
        }
    }

    public function getWebPath(): string 
    {
        return '/uploads/'.$this->path;
    }

    /**
     * @ORM\PreRemove()
     */
    public function remove()
    {
        if (is_file($this->getPublicRootDir().$this->path)) {
            unlink($this->getPublicRootDir().$this->path);
        }
    }
}
