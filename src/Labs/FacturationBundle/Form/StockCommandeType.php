<?php

namespace Labs\FacturationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StockCommandeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal product_qte', "placeholder"=>"Quantité entrée",'required'=>'required')))
            ->add('entrepot','entity',array(
                'label' => false,
                'class' => 'Labs\FacturationBundle\Entity\Entrepot',
                'choice_label' => 'name',
                'expanded' => false,
                'attr' => array('class'=>'select-border-color border-teal border-lg entrepot_ref','style'=>'text-transform: uppercase'),
                'required' => false
            ))
            ->add('mouvement','entity',array(
                'label' => false,
                'class' => 'Labs\FacturationBundle\Entity\Mouvement',
                'choice_label' => 'name',
                'expanded' => false,
                'attr' => array('class'=>'select-border-color border-teal border-lg','style'=>'text-transform: uppercase'),
                'required' => false
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Labs\FacturationBundle\Entity\Stock'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'labs_facturationbundle_cmd_stock';
    }
}
