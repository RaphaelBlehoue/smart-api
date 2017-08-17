<?php

namespace Labs\FacturationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProformaEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('local')
            ->remove('end')
            ->remove('start')
            ->remove('services')
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'labs_facturationbundle_edit_proforma';
    }


    public function getParent()
    {
        return new ProformaType();
    }
}
