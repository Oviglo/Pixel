<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * @ORM\Entity
 */
class Game 
{
    /**
     * @var int
     * 
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=80)
     */
    private $title;

    /**
     * @var string
     * 
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @var bool 
     * 
     * @ORM\Column(type="boolean")
     */
    private $enabled = false;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Support::class, inversedBy="games")
     * 
     * Si le support est supprimé, cette propriété sera à null
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $support;

    /**
     * orphanRemoval indique que l'entité Image est supprimé s'il n'y a plus de connexion avec l'entité Game
     * @ORM\OneToOne(targetEntity=Image::class, cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $image;

    /**
     * @var bool
     */
    private $deleteImage = false;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="games")
     * @ORM\JoinColumn(onDelete="SET NULL")
     * @Ignore()
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="games")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Like::class, mappedBy="game", orphanRemoval=true)
     */
    private $likes;

    public function __construct()
    {
        // Met automatiquement la date de création
        $this->createdAt = new \DateTime;
        $this->categories = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    /**
     * Get the value of id
     *
     * @return  int
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of title
     *
     * @return  string
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param  string  $title
     *
     * @return  self
     */ 
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of content
     *
     * @return  string
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @param  string  $content
     *
     * @return  self
     */ 
    public function setContent(string $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of enabled
     *
     * @return  bool
     */ 
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set the value of enabled
     *
     * @param  bool  $enabled
     *
     * @return  self
     */ 
    public function setEnabled(bool $enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get the value of createdAt
     *
     * @return  \DateTime
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @param  \DateTime  $createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSupport(): ?Support
    {
        return $this->support;
    }

    public function setSupport(?Support $support): self
    {
        $this->support = $support;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of deleteImage
     *
     * @return  bool
     */ 
    public function getDeleteImage()
    {
        return $this->deleteImage;
    }

    /**
     * Set the value of deleteImage
     *
     * @param  bool  $deleteImage
     *
     * @return  self
     */ 
    public function setDeleteImage(bool $deleteImage)
    {
        $this->deleteImage = $deleteImage;

        if ($deleteImage) {
            $this->image = null;
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection|Like[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setGame($this);
        }

        return $this;
    }

    public function removeLike(Like $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getGame() === $this) {
                $like->setGame(null);
            }
        }

        return $this;
    }
}