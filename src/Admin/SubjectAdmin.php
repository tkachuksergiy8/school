<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\{
    AbstractAdmin,
    AdminInterface
};
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class SubjectAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
                ->add('title')
                ->add('teachers')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
                ->addIdentifier('id')
                ->addIdentifier('title')
        ;
    }

}
