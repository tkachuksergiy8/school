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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $initialAssessment;

    /**
     * @ORM\Column(type="text", nullable=true)
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

    public function __construct()
    {
        $this->buyedSessions = new ArrayCollection();
        $this->completedSessions = new ArrayCollection();
        $this->sessions = new ArrayCollection();
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

    public function getInitialAssessment(): ?int
    {
        return $this->initialAssessment;
    }

    public function setInitialAssessment(?int $initialAssessment): self
    {
        $this->initialAssessment = $initialAssessment;

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

    public function getInitialAnswers(): ?string
    {
        return $this->initialAnswers;
    }

    public function setInitialAnswers(?string $initialAnswers): self
    {
        $this->initialAnswers = $initialAnswers;

        return $this;
    }

}
