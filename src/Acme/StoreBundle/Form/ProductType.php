<?php

namespace Acme\StoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
            ->add('price', 'text')
            ->add('save', 'submit', array('label' => 'Create Product'));

    }

    public function getName()
    {
        return 'product';
    }
}
