<?php

namespace Labs\FacturationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProformaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal arrete', "placeholder"=>"Objet de la proforma")))
            ->add('local',null,array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Localisation"),'required' => false))
            ->add('start','date',array(
                    'label'=>false,
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'attr'=>array('class'=>'form-control', 'placeholder'=> 'Date de début'),
                    'required' => false
            ))
            ->add('end','date',array(
                    'label'=> false,
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                    'attr'=>array('class'=>'form-control','placeholder'=> 'Date de fin'),
                    'required' => false
            ))
            ->add('clients','entity',array(
                'label' => false,
                'class' => 'Labs\MembersBundle\Entity\Client',
                'choice_label' => 'name',
                "placeholder"=>"Attribué la proforma à un client",
                'expanded' => false,
                'attr' => array('class'=>'select-border-color border-teal border-lg','style'=>'text-transform: uppercase'),
                'required' => true
            ))
            ->add('services','entity',array(
                'label' => false,
                'class' => 'Labs\FacturationBundle\Entity\Service',
                'choice_label' => 'name',
                "placeholder"=>"Choix du service (Vente ou location)",
                'expanded' => false,
                'attr' => array('class'=>'select-border-color border-teal border-lg form-service','style'=>'text-transform: uppercase'),
                'required' => true
            ))
            ->add('conditions','entity',array(
                'label' => false,
                'class' => 'Labs\FacturationBundle\Entity\Conditions',
                'choice_label' => 'name',
                "placeholder"=>"Condition de réglement de la proforma",
                'expanded' => false,
                'attr' => array('class'=>'select-border-color border-teal border-lg','style'=>'text-transform: uppercase'),
                'required' => false
            ))
            ->add('compagny','entity',array(
                'label' => false,
                'class' => 'Labs\FacturationBundle\Entity\Compagny',
                'choice_label' => 'name',
                'expanded' => false,
                'attr' => array('class'=>'select-border-color border-teal border-lg','style'=>'text-transform: uppercase'),
                'required' => true
            ))

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Labs\FacturationBundle\Entity\Proforma'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'labs_facturationbundle_proforma';
    }
}
