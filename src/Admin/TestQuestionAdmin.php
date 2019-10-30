<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\Form\Type\CollectionType;

class TestQuestionAdmin extends AbstractAdmin
{

    protected $parentAssociationMapping = 'test';

    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
                ->add('question')
                ->add('points')
                ->add('answers', CollectionType::class, [
                    'by_reference' => false
                        ], [
                    'edit' => 'inline',
                    'inline' => 'table'
                ])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('question');
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        if ($this->isChild()) {
            return;
        }

        $collection->clear();
    }

    public function toString($question)
    {
        return $question->getQuestion();
    }

}
