<?php

namespace TM\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SubcategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subcategory', 'entity', array(
                                                  'class'    => 'TMBlogBundle:Subcategory',
                                                  'property' => 'name',
                                                  'multiple' => false,
                                                  'label' => 'Catégories'
                                                ))
            ->add('save', 'submit', array('label'=>'Aller à l\'article'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TM\BlogBundle\Entity\Subcategory'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tm_blogbundle_subcategory';
    }
}
