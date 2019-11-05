<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\{HiddenType, TextType, TextareaType};
use FOS\UserBundle\Form\Type\ProfileFormType;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ProfileType extends AbstractType
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('photo', Type\ImageFileType::class, [
                    'required' => false,
                    'label' => false,
                    'upload_path' => $this->container->getParameter('user_profile_photos'),
                    'attr' => ['accept' => 'image/*']
                ])
                ->add('firstName', TextType::class, [
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control form-control-lg'
                    ]
                ])
                ->add('lastName', TextType::class, [
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control form-control-lg'
                    ]
                ])
                ->add('about', TextareaType::class, [
                    'required' => false,
                    'attr' => [
                        'class' => 'form-control form-control-lg text-editor'
                    ]
                ])
                ->add('base64_photo', HiddenType::class, [
                    'required' => false,
                    'mapped' => null
                ])
        ;
    }

    public function getParent()
    {
        return ProfileFormType::class;
    }

}
