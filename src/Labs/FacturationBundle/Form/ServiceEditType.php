<?php

namespace Labs\FacturationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ServiceEditType extends AbstractType
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
        return 'labs_facturationbundle_edit_service';
    }

    public function getParent()
    {
        return new ServiceType();
    }
}
