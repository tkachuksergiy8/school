<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LessonRepository")
 */
class Lesson
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
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Subject", inversedBy="lessons")
     */
    private $subject;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $course;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Shedule", mappedBy="lessons")
     */
    private $shedules;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    public function __construct()
    {
        $this->teachers = new ArrayCollection();
        $this->shedules = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->reference . ' ' . $this->title;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSubject(): ?Subject
    {
        return $this->subject;
    }

    public function setSubject(?Subject $subject): self
    {
        $this->subject = $subject;

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
            $shedule->addLesson($this);
        }

        return $this;
    }

    public function removeShedule(Shedule $shedule): self
    {
        if ($this->shedules->contains($shedule)) {
            $this->shedules->removeElement($shedule);
            $shedule->removeLesson($this);
        }

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

}
