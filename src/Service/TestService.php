<?php

namespace App\Service;

use App\Entity\TestQuestion;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Test;

class TestService
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getResult($questions, array $input)
    {
        $correctAnswers = array();

        foreach ($questions as $question) {
            $correct = $question->getAnswers()->filter(function($answer) {
                return $answer->getCorrect();
            })->first();

            $correctAnswers[$question->getId()] = $correct->getId();
        }

        $answers = array_intersect_assoc($correctAnswers, $input);

        $testQuestion = $this->em->getRepository(TestQuestion::class);

        array_walk($answers, function (&$item, $key) use ($testQuestion){
            $item = $testQuestion->find($key)->getPoints();
        });

        return array_sum($answers);
    }

    private function getTest(int $testId): Test
    {
        return $this->em->find(Test::class, $testId);
    }

}
