<?php

namespace App\Entity;

use App\Repository\StarRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StarRepository::class)
 */
class Star
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Mentor::class, inversedBy="stars")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mentor;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="stars")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMentor(): ?Mentor
    {
        return $this->mentor;
    }

    public function setMentor(?Mentor $mentor): self
    {
        $this->mentor = $mentor;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }
}
