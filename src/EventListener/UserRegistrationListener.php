<?php

namespace App\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserRegistrationListener implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            FOSUserEvents::REGISTRATION_SUCCESS => 'setRole'
        ];
    }

    public function setRole(FormEvent $event)
    {
        $form = $event->getForm();
        $role = $form['role']->getData();

        if (!$role || !in_array($role, ['student', 'teacher'])) {
            return;
        }

        $roleName = ucfirst($role);
        $entityFullName = '\\App\\Entity\\' . $roleName;
        $setter = 'add' . $roleName;

        $user = $form->getData();
        $user->addRole('ROLE_' . strtoupper($role));

        $object = new $entityFullName;
        $object->setUser($user);

        $user->$setter($object);
    }

}
