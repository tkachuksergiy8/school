<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\{
    ListMapper,
    DatagridMapper
};
use Sonata\AdminBundle\Form\FormMapper;

class LessonAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('subject')
                ->add('course')
                ->add('reference')
                ->add('title')
                ->add('content')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('subject')
                ->addIdentifier('course')
                ->addIdentifier('reference')
                ->addIdentifier('title')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
                ->add('subject')
                ->add('course')
                ->add('reference')
                ->add('title')
        ;
    }

}
