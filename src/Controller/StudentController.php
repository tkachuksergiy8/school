<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\{
    Response,
    Request
};
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\{InitialTestRepository, SubjectRepository, TestRepository, SessionRepository, StudentRepository};
use App\Entity\Test;
use App\Service\TestService;

/**
 * @IsGranted("ROLE_STUDENT")
 * @Route("student/")
 */
class StudentController extends AbstractController
{

    /**
     * @Route("", name="student")
     */
    public function index(): Response
    {
        return $this->render('student/index.html.twig');
    }

    /**
     * @Route("initial-tests", name="student_initial_tests")
     */
    public function initialTests(InitialTestRepository $testRepo, StudentRepository $studentRepo, SubjectRepository $subjectRepo): Response
    {
        $student = $studentRepo->findOneBy(['user' => $this->getUser()]);

        $selectedSubjects = array_map(function ($item) {
            return $item->getId();
        }, $student->getCompletedInitialSubjects()->getValues());

        $allSubjectsId = array_map(function ($item) {
            return $item->getId();
        }, $subjectRepo->findAll());

        $tests = $testRepo->findBy([
            'subject' => array_diff($allSubjectsId, $selectedSubjects)
        ]);

        if (!$student) {
            return new Response('You are not student');
        }

        return $this->render('student/initial_tests.html.twig', [
            'tests' => $tests
        ]);
    }

    /**
     * @Route("available-sessions", name="student_available_sessions")
     */
    public function availableSessions(Request $request, SessionRepository $sessionRepo, StudentRepository $studentRepo): Response
    {
        $student = $studentRepo->findOneBy(['user' => $this->getUser()]);

        if (!$student) {
            return new Response('You are not student');
        }

        if ($request->request->has('session')) {
            if (!$this->isCsrfTokenValid('session-buy', $request->get('token'))) {
                return new Response('You are the bot');
            }

            $sessionId = $request->get('session')['id'];
            $student->addBuyedSession($sessionRepo->find($sessionId));
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Success buyed!');

            return $this->redirectToRoute('student_available_sessions');
        }

        return $this->render('student/available_sessions.html.twig', [
                    'sessions' => $sessionRepo->findAll(),
                    'student' => $student
        ]);
    }

    /**
     * @Route("sessions", name="student_sessions")
     */
    public function buyedSessions(StudentRepository $studentRepo): Response
    {
        $student = $studentRepo->findOneBy(['user' => $this->getUser()]);

        return $this->render('student/sessions.html.twig', [
                    'sessions' => $student->getSessions()
        ]);
    }

    /**
     * @Route("initial-assessment/{id<\d+>}", name="student_initial_assessment")
     */
    public function initialAssessment(int $id, Request $request, InitialTestRepository $initialTestRepo, StudentRepository $studentRepo, TestService $testService): Response
    {
        if (isset($studentRepo->findOneBy(['user' => $this->getUser()])->getInitialAnswers()[$id])) {
            return $this->redirectToRoute('student_initial_tests');
        }

        $student = $studentRepo->findOneBy(['user' => $this->getUser()]);
        $questions = $initialTestRepo->find($id)->getQuestions()->getValues();

        if (!$student) {
            return new Response('You are not student');
        }

        if ($request->request->has('test')) {
            if (!$this->isCsrfTokenValid('initial-test', $request->get('token'))) {
                return new Response('You are the bot');
            }

            $initialAnswers = array();

            if (!empty($student->getInitialAnswers())) {
                $initialAnswers = $student->getInitialAnswers();
            }

            $initialAnswers[$id] = $testService->getTestAnswers($questions,  $request->get('test'), $id);
            $student->setInitialAnswers($initialAnswers);
            $student->addCompletedInitialSubject($initialTestRepo->find($id)->getSubject());

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('student_initial_tests');
        }

        return $this->render('student/initial_assessment.html.twig', [
            'questions' => $questions,
            'student' => $student
        ]);
    }
}
