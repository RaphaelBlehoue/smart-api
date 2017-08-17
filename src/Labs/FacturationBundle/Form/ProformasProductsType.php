<?php

namespace Labs\FacturationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProformasProductsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('qteCmd','text',array(
                'label'=>false,
                'attr' =>array('class'=> 'form-control border-teal border-lg text-teal product_qte_command', "placeholder"=>"Qte"
                ),
                'required'=>'required'
                )
            )
            ->add('price','text',array(
                'label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal product_price', "placeholder"=>"Mentionnez un autre prix"
                ),
                'required' => false
                )
            )
            ->add('duration','text',array(
                'label'=>false,
                'attr' =>array('class'=> 'form-control border-teal border-lg text-teal product_duration', "placeholder"=>"Durée",
                ),
                'required' => false
                )
            )
            ->add('remise','text',array(
                'label'=>false,
                'attr' =>array('class'=> 'form-control border-teal border-lg text-teal product_remise',
                    "placeholder"=>"Remise"
                ),
                  'required' => false
                )
            )
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Labs\FacturationBundle\Entity\ProformasProducts'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'labs_facturationbundle_proformasproducts';
    }
}
