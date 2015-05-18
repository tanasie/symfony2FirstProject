<?php

namespace Acme\CategoryBundle\Controller;

use Acme\CategoryBundle\Document\Category;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
class CategoryController extends FOSRestController
{
    public function getCategoryAction($id)
    {
        $category = $this->get('doctrine_mongodb')
            ->getRepository('AcmeCategoryBundle:Category')
            ->findOneById($id);

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($category, 'json');
        return new Response($jsonContent);
    }

    public function createSomeDataAction()
    {
        $category = new Category();
        $category->setName('category 2');
        $category->setDescription('lorem ipsum dolor sit amet');
        $dm = $this->get('doctrine_mongodb')->getManager();

        $dm->persist($category);
        $dm->flush();

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($category, 'json');
        return new Response($jsonContent);
    }

}