<?php

namespace Acme\ProductBundle\Controller;

use Acme\ProductBundle\Document\Product;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
class ProductDocumentController extends FOSRestController
{

    public function getProductByIdAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $this->get('doctrine_mongodb')
            ->getRepository('AcmeProductBundle:Product')
            ->findOneById($id);

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($product, 'json');
        return new Response($jsonContent);
    }


    public function createProductAction()
    {
        $product = new Product();
        $product->setName('product 1');
        $product->setPrice('1');
        $product->setDescription('lorem ipsum dolor sit amet');

        $dm = $this->get('doctrine_mongodb')->getManager();

        $dm->persist($product);
        $dm->flush();

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($product, 'json');
        return new Response($jsonContent);
    }
}
