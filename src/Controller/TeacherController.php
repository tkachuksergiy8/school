<?php

namespace App\Controller;

use App\Form\TeacherType;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_TEACHER")
 * @Route("teacher")
 */
class TeacherController extends AbstractController
{
    /**
     * @Route("/", name="teacher")
     */
    public function index()
    {
        return $this->render('teacher/index.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }

    /**
     * @Route("/profile", name="teacher_profile")
     */
    public function profile(TeacherRepository $teacherRepo)
    {
        $t = $teacherRepo->findOneBy(['user' => $this->getUser()]);
        $form = $this->createForm(TeacherType::class, $t);

        return $this->render('teacher/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
