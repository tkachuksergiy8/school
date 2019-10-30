<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\{
    Response,
    Request
};
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\{
    TestRepository,
    SessionRepository,
    StudentRepository
};
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
     * @Route("initial-assessment", name="student_initial_assessment")
     */
    public function initialAssessment(Request $request, TestRepository $testRepo, StudentRepository $studentRepo, TestService $testService): Response
    {
        $test = $testRepo->findOneBy(['type' => Test::TYPE_INITIAL]);
        $student = $studentRepo->findOneBy(['user' => $this->getUser()]);

        if (!$student) {
            return new Response('You are not student');
        }

        if ($request->request->has('test')) {
            if (!$this->isCsrfTokenValid('initial-test', $request->get('token'))) {
                return new Response('You are the bot');
            }

            $result = $testService->getResult($test, $request->get('test'));
            $student->setInitialAssessment($result);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('student_initial_assessment');
        }

        return $this->render('student/initial_assessment.html.twig', [
                    'test' => $test,
                    'student' => $student
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
                    'sessions' => $student->getBuyedSessions()
        ]);
    }

}
