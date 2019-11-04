<?php


namespace App\Form;

use App\Entity\Subject;
use App\Entity\Teacher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\{
    IntegerType,
    SubmitType,
    TextareaType};
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class TeacherType extends AbstractType
{
    private $user;

    public function __construct(Security $ts)
    {
        $this->user=$ts->getToken()->getUser();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('profile', ProfileType::class,[
                'data' =>  $this->user,
                'mapped' => false
            ])
            ->add('yearsOfExperience', IntegerType::class, [
                'required' => true,
                'attr' => [
                    'min' => '0',
                    'max' => '80',
                    'class' => 'form-control form-control-lg'
                ]
            ])
            ->add('mainSubjects', EntityType::class, [
                'class' => Subject::class,
                'multiple' => true,
                'by_reference' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg'
                ]
            ])
            ->add('subSubjects', null, [
                'by_reference' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg'
                ]
            ])
            ->add('achievements', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control form-control-lg text-editor'
                ]
            ])
        ;

        $builder
            ->get('profile')
            ->remove('username')
            ->remove('email')
            ->remove('current_password')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Teacher::class
        ]);
    }
}