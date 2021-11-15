<?php

namespace MD\Bundle\MDUserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('username')
//            ->add('salt')
                ->add('email')
                ->add('password')
                ->add('active')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MD\Bundle\MDUserBundle\Entity\User'
        ));
    }

    public function getName() {
        return 'md_bundle_mduserbundle_usertype';
    }

}
