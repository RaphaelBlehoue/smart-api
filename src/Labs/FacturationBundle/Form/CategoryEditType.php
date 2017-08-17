<?php

namespace Labs\FacturationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoryEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {}

    /**
     * @return string
     */
    public function getName()
    {
        return 'labs_facturationbundle_category_edit';
    }

    public function getParent()
    {
        return new CategoryType();
    }
}
