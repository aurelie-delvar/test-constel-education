<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Star::class, mappedBy="student")
     */
    private $stars;

    public function __construct()
    {
        $this->stars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Star>
     */
    public function getStars(): Collection
    {
        return $this->stars;
    }

    public function addStar(Star $star): self
    {
        if (!$this->stars->contains($star)) {
            $this->stars[] = $star;
            $star->setStudent($this);
        }

        return $this;
    }

    public function removeStar(Star $star): self
    {
        if ($this->stars->removeElement($star)) {
            // set the owning side to null (unless already changed)
            if ($star->getStudent() === $this) {
                $star->setStudent(null);
            }
        }

        return $this;
    }
}
