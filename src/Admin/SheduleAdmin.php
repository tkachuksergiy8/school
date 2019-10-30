<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Lesson;

class SheduleAdmin extends AbstractAdmin
{

    protected $parentAssociationMapping = 'session';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('date')
                ->add('lessons', CollectionType::class, [
                    'by_reference' => false,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'entry_type' => EntityType::class,
                    'entry_options' => [
                        'class' => Lesson::class
                    ]
                ])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('date')
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        if ($this->isChild()) {
            return;
        }
        
        $collection->clear();
    }

    public function toString($shedule)
    {
        return 'Shedule';   
    }
}
