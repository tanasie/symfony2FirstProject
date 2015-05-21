<?php

use Acme\ProductBundle\Event\ProductEvent;

class ProductListener
{
    protected $product;

    public function __construct(\Acme\ProductBundle\Entity\Product $product)
    {
        $this->product = $product;
    }

    public function onCreateProductEvent(ProductEvent $event)
    {

        $newProduct = new \Acme\ProductBundle\Document\Product();

        $newProduct->setName($event->getName());
        $newProduct->setPrice($event->getPrice());
        $newProduct->setDescription($event->getDescription());

        $dm = $this->get('doctrine_mongodb')->getManager();

        $dm->persist($newProduct);
        $dm->flush();

    }

}