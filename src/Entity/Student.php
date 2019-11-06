<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 */
class Student
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="students")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $initialAnswers;

    /**
     * @ORM\ManyToMany(targetEntity="Session")
     * @ORM\JoinTable(name="student_buyed_sessions")
     */
    private $buyedSessions;

    /**
     * @ORM\ManyToMany(targetEntity="Session")
     * @ORM\JoinTable(name="student_completed_sessions")
     */
    private $completedSessions;

    /**
     * @ORM\OneToMany(targetEntity="Session", mappedBy="student")
     */
    private $sessions;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Subject")
     * @ORM\JoinTable(name="completed_initial_subjects")
     */
    private $completedInitialSubjects;

    public function __construct()
    {
        $this->buyedSessions = new ArrayCollection();
        $this->completedSessions = new ArrayCollection();
        $this->sessions = new ArrayCollection();
        $this->completedInitialSubjects = new ArrayCollection();
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
     * @return Collection|Session[]
     */
    public function getBuyedSessions(): Collection
    {
        return $this->buyedSessions;
    }

    public function addBuyedSession(Session $buyedSession): self
    {
        if (!$this->buyedSessions->contains($buyedSession)) {
            $this->buyedSessions[] = $buyedSession;
        }

        return $this;
    }

    public function removeBuyedSession(Session $buyedSession): self
    {
        if ($this->buyedSessions->contains($buyedSession)) {
            $this->buyedSessions->removeElement($buyedSession);
        }

        return $this;
    }

    /**
     * @return Collection|Session[]
     */
    public function getCompletedSessions(): Collection
    {
        return $this->completedSessions;
    }

    public function addCompletedSession(Session $completedSession): self
    {
        if (!$this->completedSessions->contains($completedSession)) {
            $this->completedSessions[] = $completedSession;
        }

        return $this;
    }

    public function removeCompletedSession(Session $completedSession): self
    {
        if ($this->completedSessions->contains($completedSession)) {
            $this->completedSessions->removeElement($completedSession);
        }

        return $this;
    }

    /**
     * @return Collection|Session[]
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->setStudent($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->contains($session)) {
            $this->sessions->removeElement($session);
            // set the owning side to null (unless already changed)
            if ($session->getStudent() === $this) {
                $session->setStudent(null);
            }
        }

        return $this;
    }

    public function getInitialAnswers(): ?array
    {
        return $this->initialAnswers;
    }

    public function setInitialAnswers(?array $initialAnswers): self
    {
        $this->initialAnswers = $initialAnswers;

        return $this;
    }

    /**
     * @return Collection|Subject[]
     */
    public function getCompletedInitialSubjects(): Collection
    {
        return $this->completedInitialSubjects;
    }

    public function addCompletedInitialSubject(Subject $completedInitialSubject): self
    {
        if (!$this->completedInitialSubjects->contains($completedInitialSubject)) {
            $this->completedInitialSubjects[] = $completedInitialSubject;
        }

        return $this;
    }

    public function removeCompletedInitialSubject(Subject $completedInitialSubject): self
    {
        if ($this->completedInitialSubjects->contains($completedInitialSubject)) {
            $this->completedInitialSubjects->removeElement($completedInitialSubject);
        }

        return $this;
    }

}
