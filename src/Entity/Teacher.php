<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeacherRepository")
 */
class Teacher
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="teacher", cascade="all")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="Subject", mappedBy="mainSubjectsTeachers")
     */
    private $mainSubjects;

    /**
     * @ORM\ManyToMany(targetEntity="Subject", mappedBy="subSubjectsTeachers")
     */
    private $subSubjects;

    /**
     * @ORM\Column(type="integer")
     */
    private $yearsOfExperience;

    /**
     * @ORM\Column(type="text")
     */
    private $achievements;

    public function __construct()
    {
        $this->lessons = new ArrayCollection();
        $this->subjects = new ArrayCollection();
        $this->mainSubjects = new ArrayCollection();
        $this->subSubjects = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getUser()->getFirstName() . ' ' . $this->getUser()->getLastName() . ' (' . $this->getUser()->getUsername() . ')';
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|Subject[]
     */
    public function getMainSubjects(): Collection
    {
        return $this->mainSubjects;
    }

    public function addMainSubject(Subject $mainSubject): self
    {
        if (!$this->mainSubjects->contains($mainSubject)) {
            $this->mainSubjects[] = $mainSubject;
            $mainSubject->addMainSubjectsTeacher($this);
        }

        return $this;
    }

    public function removeMainSubject(Subject $mainSubject): self
    {
        if ($this->mainSubjects->contains($mainSubject)) {
            $this->mainSubjects->removeElement($mainSubject);
            $mainSubject->removeMainSubjectsTeacher($this);
        }

        return $this;
    }

    /**
     * @return Collection|Subject[]
     */
    public function getSubSubjects(): Collection
    {
        return $this->subSubjects;
    }

    public function addSubSubject(Subject $subSubject): self
    {
        if (!$this->subSubjects->contains($subSubject)) {
            $this->subSubjects[] = $subSubject;
            $subSubject->addSubSubjectsTeacher($this);
        }

        return $this;
    }

    public function removeSubSubject(Subject $subSubject): self
    {
        if ($this->subSubjects->contains($subSubject)) {
            $this->subSubjects->removeElement($subSubject);
            $subSubject->removeSubSubjectsTeacher($this);
        }

        return $this;
    }

    public function getAchievements(): ?string
    {
        return $this->achievements;
    }

    public function setAchievements(string $achievements): self
    {
        $this->achievements = $achievements;

        return $this;
    }

    public function getYearsOfExperience(): ?int
    {
        return $this->yearsOfExperience;
    }

    public function setYearsOfExperience(int $yearsOfExperience): self
    {
        $this->yearsOfExperience = $yearsOfExperience;

        return $this;
    }

}
