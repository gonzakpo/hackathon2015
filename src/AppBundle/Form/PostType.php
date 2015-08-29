<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * PostType form.
 * @author Nombre Apellido <name@gmail.com>
 */
class PostType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('booleano')
            ->add('entero')
            ->add('smallEntero')
            ->add('bigEntero')
            ->add('cadena')
            ->add('texto')
            ->add('fechatiempo', 'bootstrapdatetime', array(
                'required'   => true,
                'label'      => 'Fechatiempo',
                'label_attr' => array(
                    'class' => 'col-lg-2 col-md-2 col-sm-2',
                ),
                'widget_type' => 'both',
            ))
            ->add('dechatiempoz', 'bootstrapdatetime', array(
                'required'   => true,
                'label'      => 'Dechatiempoz',
                'label_attr' => array(
                    'class' => 'col-lg-2 col-md-2 col-sm-2',
                ),
                'widget_type' => 'both',
            ))
            ->add('fecha', 'bootstrapdatetime', array(
                'required'   => true,
                'label'      => 'Fecha',
                'label_attr' => array(
                    'class' => 'col-lg-2 col-md-2 col-sm-2',
                ),
                'widget_type' => 'date',
            ))
            ->add('tiempo', 'bootstrapdatetime', array(
                'required'   => true,
                'label'      => 'Tiempo',
                'label_attr' => array(
                    'class' => 'col-lg-2 col-md-2 col-sm-2',
                ),
                'widget_type' => 'time',
            ))
            ->add('numerodecimal')
            ->add('numeroconcoma')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Post'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_post';
    }
}
