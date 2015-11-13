<?php

namespace Blob\Core\LibraryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SistemAyarType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('anaSayfadakiFotografSayisi',NULL,array('attr'=>array('class'=>'form-control')))
            ->add('kaydirincaGelecekFotografSayisi',NULL,array('attr'=>array('class'=>'form-control')))
            ->add('temaRenk',NULL,array('attr'=>array('class'=>'form-control')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Blob\Core\LibraryBundle\Entity\SistemAyar'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'blob_core_librarybundle_sistemayar';
    }
}
