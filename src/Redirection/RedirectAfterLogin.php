<?php

namespace App\Redirection;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\{
    Request,
    Response,
    RedirectResponse
};

class RedirectAfterLogin implements AuthenticationSuccessHandlerInterface
{

    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): Response
    {
        $user = $token->getUser();
        $roles = $user->getRoles();

        if (in_array('ROLE_ADMIN', $roles)) {
            $studentUrl = $this->router->generate('sonata_admin_dashboard');
            return new RedirectResponse($studentUrl);
        }

        if (in_array('ROLE_STUDENT', $roles)) {
            $studentUrl = $this->router->generate('student');
            return new RedirectResponse($studentUrl);
        }

        if (in_array('ROLE_TEACHER', $roles)) {
            $teacherUrl = $this->router->generate('teacher');
            return new RedirectResponse($teacherUrl);
        }

        $studentUrl = $this->router->generate('homepage');
        return new RedirectResponse($studentUrl);
    }

}
