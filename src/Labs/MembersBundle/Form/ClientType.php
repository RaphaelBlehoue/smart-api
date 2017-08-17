<?php

namespace Labs\MembersBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Entrez le nom de l'entreprise",'required'=>'required')))
            ->add('email_represent',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Entrez l'email du réprésentant",'required'=>'required')))
            ->add('email_entreprise',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Entrez l'email de l'entreprise",'required'=>'required')))
            ->add('adresse',null,array(
                'label'=>false,
                'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Entrez l'adresse de l'entreprise"),
                'required'=>false
            ))
            ->add('representant',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Nom du réprésentant de l'entreprise",'required'=>'required')))

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Labs\MembersBundle\Entity\Client'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'labs_membersbundle_client';
    }
}
