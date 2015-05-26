<?php

namespace Acme\ElasticaBundle\Form\Type;

use Acme\ElasticaBundle\Model\ProductSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',null,array(
                'required' => false,
            ))

            ->add('price',null,array(
                'required' => false,
            ))

            ->add('description',null,array(
                'required' => false,
            ))
            ->add('search','submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            // avoid to pass the csrf token in the url (but it's not protected anymore)
            'csrf_protection' => false,
            'data_class' => 'Acme\ElasticaBundle\Model\ProductSearch'
        ));
    }

    public function getName()
    {
        return 'product_search_type';
    }
}