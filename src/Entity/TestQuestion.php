<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TestQuestionRepository")
 */
class TestQuestion
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
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity="SessionTest", inversedBy="questions")
     */
    private $sessionTest;

    /**
     * @ORM\ManyToOne(targetEntity="InitialTest", inversedBy="questions")
     */
    private $initialTest;

    /**
     * @ORM\OneToMany(targetEntity="TestAnswer", mappedBy="question", cascade={"persist", "remove"})
     */
    private $answers;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $points;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->question;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }


    /**
     * @return Collection|TestAnswer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(TestAnswer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(TestAnswer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(?int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getSessionTest(): ?SessionTest
    {
        return $this->sessionTest;
    }

    public function setSessionTest(?SessionTest $sessionTest): self
    {
        $this->sessionTest = $sessionTest;

        return $this;
    }

    public function getInitialTest(): ?InitialTest
    {
        return $this->initialTest;
    }

    public function setInitialTest(?InitialTest $initialTest): self
    {
        $this->initialTest = $initialTest;

        return $this;
    }

}
