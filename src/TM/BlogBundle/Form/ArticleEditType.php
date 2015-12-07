<?php

namespace TM\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleEditType extends AbstractType
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
            ->add('subcategory', 'entity', array(
                                                  'class'    => 'TMBlogBundle:Subcategory',
                                                  'property' => 'name',
                                                  'multiple' => false,
                                                  'label' => 'Catégories'
                                                ))
            ->add('save', 'submit', array('label'=>'Modifier l\'article'))
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
