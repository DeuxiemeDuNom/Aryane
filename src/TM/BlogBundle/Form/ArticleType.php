<?php

namespace TM\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('ref', 'text')
            ->add('price', 'integer')
            ->add('description', 'textarea')
            ->add('image', new ImageType(), array('label'=>'Uploader une image'))
            ->add('date', 'datetime')
            ->add('subcategory', 'entity', array(
                                                  'class'    => 'TMBlogBundle:Subcategory',
                                                  'property' => 'name',
                                                  'multiple' => false,
                                                  
                                                ))
            ->add('save', 'submit', array('label'=>'Créer l\'article'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TM\BlogBundle\Entity\Article'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tm_blogbundle_article';
    }
}
