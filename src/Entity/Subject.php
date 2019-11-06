<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubjectRepository")
 */
class Subject
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
     * @ORM\OneToMany(targetEntity="App\Entity\Lesson", mappedBy="subject")
     */
    private $lessons;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Teacher", inversedBy="mainSubjects")
     */
    private $mainSubjectsTeachers;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Teacher", inversedBy="subSubjects")
     * @ORM\JoinTable(name="subsubject_teacher")
     */
    private $subSubjectsTeachers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\InitialTest", mappedBy="subject")
     */
    private $initialTests;

    public function __construct()
    {
        $this->lessons = new ArrayCollection();
        $this->teachers = new ArrayCollection();
        $this->mainSubjectsTeachers = new ArrayCollection();
        $this->subSubjectsTeachers = new ArrayCollection();
        $this->initialTests = new ArrayCollection();
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

    /**
     * @return Collection|Lesson[]
     */
    public function getLessons(): Collection
    {
        return $this->lessons;
    }

    public function addLesson(Lesson $lesson): self
    {
        if (!$this->lessons->contains($lesson)) {
            $this->lessons[] = $lesson;
            $lesson->setSubject($this);
        }

        return $this;
    }

    public function removeLesson(Lesson $lesson): self
    {
        if ($this->lessons->contains($lesson)) {
            $this->lessons->removeElement($lesson);
            // set the owning side to null (unless already changed)
            if ($lesson->getSubject() === $this) {
                $lesson->setSubject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Teacher[]
     */
    public function getMainSubjectsTeachers(): Collection
    {
        return $this->mainSubjectsTeachers;
    }

    public function addMainSubjectsTeacher(Teacher $mainSubjectsTeacher): self
    {
        if (!$this->mainSubjectsTeachers->contains($mainSubjectsTeacher)) {
            $this->mainSubjectsTeachers[] = $mainSubjectsTeacher;
        }

        return $this;
    }

    public function removeMainSubjectsTeacher(Teacher $mainSubjectsTeacher): self
    {
        if ($this->mainSubjectsTeachers->contains($mainSubjectsTeacher)) {
            $this->mainSubjectsTeachers->removeElement($mainSubjectsTeacher);
        }

        return $this;
    }

    /**
     * @return Collection|Teacher[]
     */
    public function getSubSubjectsTeachers(): Collection
    {
        return $this->subSubjectsTeachers;
    }

    public function addSubSubjectsTeacher(Teacher $subSubjectsTeacher): self
    {
        if (!$this->subSubjectsTeachers->contains($subSubjectsTeacher)) {
            $this->subSubjectsTeachers[] = $subSubjectsTeacher;
        }

        return $this;
    }

    public function removeSubSubjectsTeacher(Teacher $subSubjectsTeacher): self
    {
        if ($this->subSubjectsTeachers->contains($subSubjectsTeacher)) {
            $this->subSubjectsTeachers->removeElement($subSubjectsTeacher);
        }

        return $this;
    }

    /**
     * @return Collection|InitialTest[]
     */
    public function getInitialTests(): Collection
    {
        return $this->initialTests;
    }

    public function addInitialTest(InitialTest $initialTest): self
    {
        if (!$this->initialTests->contains($initialTest)) {
            $this->initialTests[] = $initialTest;
            $initialTest->setSubject($this);
        }

        return $this;
    }

    public function removeInitialTest(InitialTest $initialTest): self
    {
        if ($this->initialTests->contains($initialTest)) {
            $this->initialTests->removeElement($initialTest);
            // set the owning side to null (unless already changed)
            if ($initialTest->getSubject() === $this) {
                $initialTest->setSubject(null);
            }
        }

        return $this;
    }
}
