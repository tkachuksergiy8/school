<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SessionRepository")
 */
class Session
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
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $course;

    /**
     * @ORM\OneToMany(targetEntity="Shedule", mappedBy="session")
     */
    private $shedules;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $initialTestScore;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="SessionTest", mappedBy="session")
     */
    private $tests;

    public function __construct()
    {
        $this->shedules = new ArrayCollection();
        $this->tests = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCourse(): ?int
    {
        return $this->course;
    }

    public function setCourse(?int $course): self
    {
        $this->course = $course;

        return $this;
    }

    /**
     * @return Collection|Shedule[]
     */
    public function getShedules(): Collection
    {
        return $this->shedules;
    }

    public function addShedule(Shedule $shedule): self
    {
        if (!$this->shedules->contains($shedule)) {
            $this->shedules[] = $shedule;
            $shedule->setSession($this);
        }

        return $this;
    }

    public function removeShedule(Shedule $shedule): self
    {
        if ($this->shedules->contains($shedule)) {
            $this->shedules->removeElement($shedule);
            // set the owning side to null (unless already changed)
            if ($shedule->getSession() === $this) {
                $shedule->setSession(null);
            }
        }

        return $this;
    }

    public function getInitialTestScore(): ?int
    {
        return $this->initialTestScore;
    }

    public function setInitialTestScore(?int $initialTestScore): self
    {
        $this->initialTestScore = $initialTestScore;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|SessionTest[]
     */
    public function getTests(): Collection
    {
        return $this->tests;
    }

    public function addTest(SessionTest $test): self
    {
        if (!$this->tests->contains($test)) {
            $this->tests[] = $test;
            $test->setSession($this);
        }

        return $this;
    }

    public function removeTest(SessionTest $test): self
    {
        if ($this->tests->contains($test)) {
            $this->tests->removeElement($test);
            // set the owning side to null (unless already changed)
            if ($test->getSession() === $this) {
                $test->setSession(null);
            }
        }

        return $this;
    }

}
