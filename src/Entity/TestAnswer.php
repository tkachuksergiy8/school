<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TestAnswerRepository")
 */
class TestAnswer
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
    private $answer;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $correct;

    /**
     * @ORM\ManyToOne(targetEntity="TestQuestion", inversedBy="answers")
     */
    private $question;

    public function __toString()
    {
        return $this->answer;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getCorrect(): ?bool
    {
        return $this->correct;
    }

    public function setCorrect(?bool $correct): self
    {
        $this->correct = $correct;

        return $this;
    }

    public function getQuestion(): ?TestQuestion
    {
        return $this->question;
    }

    public function setQuestion(?TestQuestion $question): self
    {
        $this->question = $question;

        return $this;
    }

}
