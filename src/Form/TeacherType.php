<?php


namespace App\Form;

use App\Entity\Subject;
use App\Entity\Teacher;
use Doctrine\ORM\EntityRepository;
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
            ->add('achievements', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control form-control-lg text-editor'
                ]
            ])
        ;

        if(!$this->user->getTeacher()->getMainSubjects()->isEmpty()) {
            $ms = $this->user->getTeacher()->getMainSubjects();

            $builder->add('subSubjects', EntityType::class, [
                'by_reference' => false,
                'multiple' => true,
                'required' => false,
                'attr' => [
                    'class' => 'form-control form-control-lg'
                ],
                'class' => Subject::class,
                'query_builder' => function (EntityRepository $er) use($ms){
                    $qb = $er->createQueryBuilder('s');

                    return $qb->where(
                        $qb->expr()->notIn('s.title' , $ms->toArray())
                    );
                }
            ]);
        }

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