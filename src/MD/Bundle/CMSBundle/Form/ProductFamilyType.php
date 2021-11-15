<?php

namespace MD\Bundle\CMSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductFamilyType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name')
                ->add('htmlSlug', null, array('label' => 'Html Slug', 'attr' => array('class' => 'slug')))
                ->add('youtubeUrl')
                ->add('androidUrl')
                ->add('iphoneUrl')
                ->add('computerAppUrl')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MD\Bundle\CMSBundle\Entity\ProductFamily'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'md_bundle_cmsbundle_productfamily';
    }

}
