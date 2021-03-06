<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RestaurantRepository")
 */
class Restaurant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="restaurants")
     * @ORM\JoinColumn(nullable=true)
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Media", mappedBy="restaurant", orphanRemoval=true)
     */
    private $media;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="restaurant", orphanRemoval=true)
     */
    private $reviews;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="restaurants")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->Media = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection|Media[]
     */
    public function getRestaurantMedias(): Collection
    {
        return $this->RestaurantMedias;
    }

    public function addRestaurantMedia(Media $RestaurantMedia): self
    {
        if (!$this->RestaurantMedias->contains($RestaurantMedia)) {
            $this->RestaurantMedias[] = $RestaurantMedia;
            $RestaurantMedia->setRestaurant($this);
        }

        return $this;
    }

    public function removeRestaurantMedia(Media $RestaurantMedia): self
    {
        if ($this->RestaurantMedias->contains($RestaurantMedia)) {
            $this->RestaurantMedias->removeElement($RestaurantMedia);
            // set the owning side to null (unless already changed)
            if ($RestaurantMedia->getRestaurant() === $this) {
                $RestaurantMedia->setRestaurant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setRestaurant($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->contains($review)) {
            $this->reviews->removeElement($review);
            // set the owning side to null (unless already changed)
            if ($review->getRestaurant() === $this) {
                $review->setRestaurant(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getRestaurantRating() : float
    {

        $sum = 0;
        $total = 0;

        foreach($this->getReviews() as $review) {
            $sum += $review->getRating();
            $total++;
        }

        if ($total > 0) {
            return $sum/$total;
        }

        return 0;

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
}
