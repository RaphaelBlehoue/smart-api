<?php

namespace Labs\FacturationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProformaArreteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('arrete',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal arrete', "placeholder"=>"Arretez de la facture proforma", 'required'=>'required')))
            ->remove('clients')
            ->remove('services')
            ->remove('conditions')
            ->remove('compagny')
            ->remove('subject')
            ->remove('start')
            ->remove('end')
            ->remove('local')
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'labs_facturationbundle_edit_arrete_proforma';
    }


    public function getParent()
    {
        return new ProformaType();
    }
}
