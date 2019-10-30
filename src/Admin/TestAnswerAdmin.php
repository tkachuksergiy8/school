<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TestAnswerAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
                ->add('answer')
                ->add('correct')
        ;

        if (!$this->hasParentFieldDescription()) {
            $formMapper->add('question');
        }
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('answer');
    }

    public function toString($answer)
    {
        return $answer->getAnswer();
    }

}
