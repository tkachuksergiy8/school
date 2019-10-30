<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\{
    ListMapper,
    DatagridMapper
};
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\{
    EmailType,
    ChoiceType,
    PasswordType,
    RepeatedType,
    CheckboxType
};
use FOS\UserBundle\Model\UserManagerInterface;
use App\Entity\{
    Teacher,
    Student
};
use App\Form\Type\ImageFileType;

class UserAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $roles = $container->getParameter('security.role_hierarchy.roles');
        foreach ($roles as $role => $value) {
            $key = substr($role, strpos($role, "_") + 1);
            $rolesChoices[$key] = $role;
        }

        $formMapper
                ->add('photo', ImageFileType::class, [
                    'upload_path' => $this->getConfigurationPool()->getContainer()->getParameter('user_profile_photos'),
                    'file' => $this->getSubject()->getPhoto(),
                    'required' => false
                ])
                ->add('username')
                ->add('firstName')
                ->add('lastName')
                ->add('email', EmailType::class)
                ->add('enabled', CheckboxType::class, [
                    'required' => false
                ])
                ->add('roles', ChoiceType::class, [
                    'choices' => $rolesChoices ?? [],
                    'multiple' => true
                ])
                ->add('plainPassword', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'options' => ['translation_domain' => 'FOSUserBundle'],
                    'first_options' => ['label' => 'form.password'],
                    'second_options' => ['label' => 'form.password_confirmation'],
                    'invalid_message' => 'fos_user.password.mismatch',
                    'required' => false
                ])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('id')
                ->addIdentifier('firstName')
                ->addIdentifier('lastName')
                ->add('enabled', 'boolean', [
                    'editable' => true
                ])
                ->addIdentifier('getRolesAsString', null, [
                    'label' => 'Roles'
                ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $roles = $container->getParameter('security.role_hierarchy.roles');

        foreach ($roles as $role => $value) {
            $key = substr($role, strpos($role, "_") + 1);
            $rolesChoices[$key] = $role;
        }

        $datagridMapper
                ->add('firstName')
                ->add('lastName')
                ->add('roles', null, [], ChoiceType::class, [
                    'choices' => $rolesChoices
                ])
        ;
    }

    public function prePersist($user)
    {
        $this->savePass($user);
        $this->assignRoleEntity($user);
    }

    public function preUpdate($user)
    {
        $this->savePass($user);
        $this->assignRoleEntity($user);
    }

    public function setUserManager(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    public function getUserManager()
    {
        return $this->userManager;
    }

    private function savePass($user)
    {
        $this->getUserManager()->updateCanonicalFields($user);
        $this->getUserManager()->updatePassword($user);
    }

    private function assignRoleEntity($user)
    {
        if (in_array('ROLE_TEACHER', $user->getRoles())) {
            $teacher = new Teacher;
            $teacher->setUser($user);

            $user->addTeacher($teacher);
        }

        if (in_array('ROLE_STUDENT', $user->getRoles())) {
            $student = new Student;
            $student->setUser($user);

            $user->addStudent($student);
        }
    }

}
