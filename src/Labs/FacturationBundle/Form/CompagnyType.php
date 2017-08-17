<?php

namespace Labs\FacturationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompagnyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('country',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Renseignez le pays")))
            ->add('bank',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Renseignez la banque")))
            ->add('center_impot',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Renseignez le centre des impôts")))
            ->add('compte_cc',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Renseignez le compte contribuable")))
            ->add('city',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Renseignez la ville")))
            ->add('adresse',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Renseignez l'adresse")))
            ->add('street',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Renseignez la rue")))
            ->add('regime',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Regime d'imposition",'required'=>'required')))
            ->add('phone',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Renseignez le numero de tél",'required'=>'required')))
            ->add('represent',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Renseignez le Nom du répresentant",'required'=>'required')))
            ->add('phoneTwo',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Deuxieme numero de tél")))
            ->add('name',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Nom de l'entreprise",'required'=>'required')))
            ->add('file',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal file-styled', "placeholder"=>"Adresse email entreprise")))
            ->add('email',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Adresse email entreprise",'required'=>'required')))
            ->add('fax',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Entrez le fax",'required'=>'required')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Labs\FacturationBundle\Entity\Compagny'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'labs_facturationbundle_compagny';
    }
}

