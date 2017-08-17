<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Labs\MembersBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;


class ProfileFormType extends baseType
{
    protected function buildUserForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildUserForm($builder, $options);
        $builder
            ->add('firstname','text',array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Votre nom")))
            ->add('lastname','text',array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Votre prenom")))
            ->add('email','text',array('label'=>false, 'attr' =>array('class'=> 'form-control border-teal border-lg text-teal', "placeholder"=>"Adresse email")))
            ->add('current_password', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'), array(
                'label' => false,
                'translation_domain' => 'FOSUserBundle',
                'mapped' => false,
                'constraints' => new UserPassword(),
            ))
            ->remove('username')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Labs\MembersBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'mem_user_profile_edit';
    }
}
