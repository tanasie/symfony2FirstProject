<?php

namespace Acme\ProductBundle\Controller;

use Acme\ProductBundle\Document\Product;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class ProductDocumentController extends FOSRestController
{

    /**
     * @param $id
     * @return Response
     */

    public function getProductByIdAction($id)
    {
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
        $product->setName('product1');
        $product->setPrice('2');
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

    /**
     * Create a new resource
     *
     */

    public function postProductByNameAction($name)
    {

        $dm = $this->get("doctrine_mongodb")->getManager();

        $products = $dm->getRepository('AcmeProductBundle:Product')
            ->findByName($name);

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($products, 'json');
        return $this->redirectToRoute('acme_test_products',
            array('content' => $jsonContent,
                  '_format' => 'json'
            )
        );
    }

}
