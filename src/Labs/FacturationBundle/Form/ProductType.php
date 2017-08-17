<?php

namespace Labs\FacturationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Entrez le nom du produit",'required'=>'required')))
            ->add('reference',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Renseignez la réference",'required'=>'required')))
            ->add('buy_price',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Prix d'achat du produit")))
            ->add('hire_price',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Prix de location du produit")))
            ->add('cout',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Coût du service")))
            ->add('coef',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Entrez le coefficient appliqué au prix d'achat")))
            ->add('min_stock',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Renseignez le seuil de stock pour ce produit")))
            ->add('description','textarea', array('label'=> false, 'attr' => array('class'=>'wysiwyg demo-form-wysiwyg', 'id' => 'wysiwyg5', 'placeholder'=>'Entrez la description')))
            ->add('type','choice',array(
                'label'       => false,
                'choices'     => array( 0 => 'Bien', 1 => 'Service'),
                'attr'        => array('class'=>'select-border-color border-teal border-lg product-type', 'style' => 'text-transform: uppercase'),
                'required'    => false,
                'empty_value' => '- Choisissez une option -',
                'empty_data' => -1
            ))
            ->add('unites','entity',array(
                'label' => false,
                'class' => 'Labs\FacturationBundle\Entity\Unite',
                'choice_label' => 'code',
                'expanded' => false,
                'attr' => array('class'=>'select-border-color border-teal border-lg','style'=>'text-transform: uppercase'),
                'required' => false,
                'empty_value' => '- Choisissez une option -',
            ))
            ->add('marks','entity',array(
                'label' => false,
                'class' => 'Labs\FacturationBundle\Entity\Mark',
                'choice_label' => 'name',
                'expanded' => false,
                'attr' => array('class'=>'select-border-color border-teal border-lg','style'=>'text-transform: uppercase'),
                'required' => false,
                'empty_value' => '- Choisissez une option -',
            ))
            ->add('category','entity',array(
                'label' => false,
                'class' => 'Labs\FacturationBundle\Entity\Category',
                'choice_label' => 'name',
                'expanded' => false,
                'attr' => array('class'=>'select-border-color border-teal border-lg','style'=>'text-transform: uppercase'),
                'required' => false,
                'empty_value' => '- Choisissez une option -',
            ))
        ;

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Labs\FacturationBundle\Entity\Product'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'labs_facturationbundle_product';
    }
}
