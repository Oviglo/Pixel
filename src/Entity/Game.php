<?php 

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

// Indique à Doctrine que cette classe correspond à une table
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class Game
{
    #[ORM\Id] // Clé primaire
    #[ORM\GeneratedValue] // Auto increment
    #[ORM\Column]
    private int|null $id = null;

    #[ORM\Column]
    private string $name;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private string|null $description;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private \DateTime|null $releaseDate = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    #[ORM\JoinColumn(onDelete: 'SET NULL')] // Met cette valeur à null lorsque la catégorie est supprimée
    private ?Category $category = null;

    #[ORM\ManyToMany(targetEntity: Support::class, inversedBy: 'games')]
    private Collection $supports;

    #[ORM\Column(nullable: true)]
    private ?bool $published = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    private ?User $author = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    public function __construct()
    {
        $this->supports = new ArrayCollection();
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void 
    {
        $this->updatedAt = new \DateTime();
    }

    public function getId(): int|null
    {
        return $this->id;
    }
 
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): null|string
    {
        return $this->description;
    }

    public function setDescription(null|string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getReleaseDate(): \DateTime|null
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTime|null $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Support>
     */
    public function getSupports(): Collection
    {
        return $this->supports;
    }

    public function addSupport(Support $support): static
    {
        if (!$this->supports->contains($support)) {
            $this->supports->add($support);
        }

        return $this;
    }

    public function removeSupport(Support $support): static
    {
        $this->supports->removeElement($support);

        return $this;
    }

    public function isPublished(): ?bool
    {
        return $this->published ?? false; // null !== $this->published ? $this->published : false
    }

    public function setPublished(?bool $published): static
    {
        $this->published = $published;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}