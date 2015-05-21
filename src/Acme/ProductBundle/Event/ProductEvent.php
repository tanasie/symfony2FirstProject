<?php

namespace Acme\ProductBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class ProductEvent extends Event
{
    protected $pName;
    protected $price;
    protected $description;

    public function __construct($name,$price,$description)
    {
        $this->pName = $name;
        $this->price= $price;
        $this->description= $description;
    }

    public function getPName()
    {
        return $this->pName;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getDescription()
    {
        return $this->description;
    }

}