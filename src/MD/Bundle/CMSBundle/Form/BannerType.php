<?php

namespace MD\Bundle\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BannerType extends AbstractType {

    public $placmentData = 1;

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('title', null, array('label' => 'Banner Title'))
                ->add('placement', 'choice', array(
                    'choices' => array(
                        1 => 'Home Page',
                        2 => 'Dynamic Pages',
                        3 => 'Product Page',
                        4 => 'Solution Page',
                        5 => 'Contact Us Page',
                    ),
                    'data' => $this->placmentData
                ))
                ->add('url', null, array('label' => 'Banner Url'))
                ->add('text', null, array('label' => 'Banner Text', 'required' => false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MD\Bundle\CMSBundle\Entity\Banner'
        ));
    }

    public function getName() {
        return 'md_bundle_cmsbundle_bannertype';
    }

}
