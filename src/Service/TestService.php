<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Test;

class TestService
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getResult($test, array $input)
    {
        if (is_int($test)) {
            $test = $this->getTest($test);
        }

        $questions = $test->getQuestions();

        $points = $questions->map(function($question) use ($input) {
            $correct = $question->getAnswers()->filter(function($answer) {
                return $answer->getCorrect();
            })->first();

            if ($input[$question->getId()] == $correct->getId()) {
                return $question->getPoints();
            }

            return 0;
        });

        return array_sum($points->toArray());
    }

    private function getTest(int $testId): Test
    {
        return $this->em->find(Test::class, $testId);
    }

}
