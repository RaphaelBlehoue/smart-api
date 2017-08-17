<?php

namespace Labs\FacturationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntrepotType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Nommage de l'entrepôt",'required'=>'required')))
            ->add('lng',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Coordonnée GPS - longitude")))
            ->add('lnt',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Coordonnée GPS - latitude")))
            ->add('site','entity',array(
                'label' => false,
                'class' => 'Labs\FacturationBundle\Entity\Site',
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
            'data_class' => 'Labs\FacturationBundle\Entity\Entrepot'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'labs_facturationbundle_entrepot';
    }
}
