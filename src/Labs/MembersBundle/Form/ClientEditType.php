<?php

namespace Labs\MembersBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ClientEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'labs_membersbundle_edit_client';
    }


    public function getParent()
    {
        return new ClientType();
    }
}
