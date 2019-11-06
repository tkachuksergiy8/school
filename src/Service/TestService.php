<?php

namespace App\Service;

use App\Entity\InitialTest;
use App\Entity\TestAnswer;
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

    private function getInitialTest(int $testId): InitialTest
    {
        return $this->em->find(InitialTest::class, $testId);
    }

    public function getTestAnswers($questions, array $input, int $testId)
    {
        $allAnswers = array();
        $countCorrectAnswers = 0;
        $countQuestions = count($questions);
        $sumPoints = 0;

        foreach ($questions as $question) {
            $studentAnswer = $this->em->find(TestAnswer::class, $input[$question->getId()]);

            $correctAnswer = $question->getAnswers()->filter(function($answer) {
                return $answer->getCorrect();
            })->first();

            $points = 0;

            if ($studentAnswer->getId() === $correctAnswer->getId()) {
                $points = $question->getPoints();
                $sumPoints += $points;
                $countCorrectAnswers++;
            }

            $questionAnswers = array_map(function ($item){
                return $item->getAnswer();
            }, $question->getAnswers()->getValues());

            $arr = array(
                'question' => $question->getQuestion(),
                'studentAnswer' => $studentAnswer->getAnswer(),
                'correctAnswer' => $correctAnswer->getAnswer(),
                'questionAnswers' => $questionAnswers,
                'points' => $points

            );

            array_push($allAnswers, $arr);
        }

        $result = array(
            'title' => $this->getInitialTest($testId)->getTitle(),
            'countCorrectAnswer' => $countCorrectAnswers,
            'countQuestions' => $countQuestions,
            'sumPoints' => $sumPoints,
            'allAnswers' => $allAnswers,
            'subjectTitle' => $this->getInitialTest($testId)->getSubject()->getTitle(),
            'subjectId' => $this->getInitialTest($testId)->getSubject()->getId()
        );

        return $result;
    }

}
