<?php

namespace App\Controller;

use App\Form\TeacherType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function profile(Request $request)
    {
        $teacher = $this->getUser()->getTeacher();
        $form = $this->createForm(TeacherType::class, $teacher);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $base64Image = $form->get('profile')->get('base64_photo')->getData();

            if (!empty($base64Image)) {
                $savePath = $this->getParameter('user_profile_photos');
                $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
                $fileName = md5(uniqid()) . '.png';
                file_put_contents($savePath.'/'.$fileName, $data);
                $this->getUser()->setPhoto($fileName);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($teacher);
            $em->flush();

            if($teacher->getSubSubjects()->isEmpty()){
                return $this->redirectToRoute('teacher_profile');
            }

            return $this->redirectToRoute('show_teacher_profile');
        }

        return $this->render('teacher/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profile/show", name="show_teacher_profile")
     */
    public function profileShow()
    {
        $user = $this->getUser();

        $mainSubjects = array_map(function ($e) {
            return $e->getTitle();
        },  $user->getTeacher()->getMainSubjects()->getValues());

        $subSubjects = array_map(function ($e) {
            return $e->getTitle();
        },  $user->getTeacher()->getSubSubjects()->getValues());

        $subjects['mainSubject'] = implode(", ", $mainSubjects);
        $subjects['subSubject'] = implode(", ", $subSubjects);

        return $this->render('teacher/show_profile.html.twig', [
            'user' => $user,
            'subjects' => $subjects
        ]);
    }
}
