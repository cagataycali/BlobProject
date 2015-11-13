<?php

namespace Blob\Core\LibraryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FotografType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url',NULL,array('attr'=>array('class'=>'form-control')))
            ->add('hash',NULL,array('attr'=>array('class'=>'form-control')))
            ->add('icerik',NULL,array('attr'=>array('class'=>'form-control')))
            ->add('kullanici', NULL, array('empty_value' => 'Kullanıcı seçiniz', 'attr' => array('class' => 'form-control', 'placeholder' => 'Kullanıcı'), 'label' =>'Kullanıcı:', 'label_attr' => array('class' => 'control-label')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Blob\Core\LibraryBundle\Entity\Fotograf'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'blob_core_librarybundle_fotograf';
    }
}
