<?php

namespace App\Entity;

//use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ItemRepository::class)]

/**
 * @ORM\Entity(repositoryClass=ItemRepository::class)
 * @UniqueEntity("slug")
 * @ORM\Entity(repositoryClass=ItemRepository::class)
 */
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subtitle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $alias = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $translit = null;

    #[ORM\Column(nullable: true)]
    private ?bool $hightPriority = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $site = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lng = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $teaser = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'items')]
    private Collection $category;

    #[ORM\Column(nullable: true)]
    private ?bool $hidden = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['item:list', 'item:item'])]
    private ?string $slug = null;

    #[ORM\ManyToMany(targetEntity: Location::class, inversedBy: 'items')]
    private Collection $location;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->created = new \DateTime();
        $this->location = new ArrayCollection();
    }

    public function __toString(): string
    {
        return 'ID - ' . $this->id . ' ' .$this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(?string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getTranslit(): ?string
    {
        return $this->translit;
    }

    public function setTranslit(?string $translit): self
    {
        $this->translit = $translit;

        return $this;
    }

    public function isHightPriority(): ?bool
    {
        return $this->hightPriority;
    }

    public function setHightPriority(?bool $hightPriority): self
    {
        $this->hightPriority = $hightPriority;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhone2(): ?string
    {
        return $this->phone2;
    }

    public function setPhone2(?string $phone2): self
    {
        $this->phone2 = $phone2;

        return $this;
    }

    public function getPhone3(): ?string
    {
        return $this->phone3;
    }

    public function setPhone3(?string $phone3): self
    {
        $this->phone3 = $phone3;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSite(): ?string
    {
        return $this->site;
    }

    public function setSite(?string $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(?string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?string
    {
        return $this->lng;
    }

    public function setLng(?string $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    public function getTeaser(): ?string
    {
        return $this->teaser;
    }

    public function setTeaser(?string $teaser): self
    {
        $this->teaser = $teaser;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }

    public function isHidden(): ?bool
    {
        return $this->hidden;
    }

    public function setHidden(?bool $hidden): self
    {
        $this->hidden = $hidden;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Location>
     */
    public function getLocation(): Collection
    {
        return $this->location;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->location->contains($location)) {
            $this->location->add($location);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        $this->location->removeElement($location);

        return $this;
    }
}
