<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\{
    AbstractAdmin,
    AdminInterface
};
use App\Entity\SessionTest;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Test;

class TestAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $test = $this->getSubject();

        $formMapper
                ->add('title')
                ->add('subject');

        if ($test->getId()) {
            if ($test instanceof SessionTest) {
                $formMapper->add('session');
            }
        } else {
            $formMapper->addHelp('type', 'Save before continue');
        }
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('title');
    }

    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && !in_array($action, ['edit', 'show'])) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;

        $id = $admin->getRequest()->get('id');

        if ($this->isGranted('EDIT')) {
            $menu->addChild('test', [
                'uri' => $admin->generateUrl('edit', ['id' => $id])
            ]);
        }

        if ($this->isGranted('LIST')) {
            $menu->addChild('questions', [
                'uri' => $admin->generateUrl('admin.test.question.list', ['id' => $id])
            ]);
        }
    }

    public function toString($test)
    {
        return $test->getTitle();
    }

}
