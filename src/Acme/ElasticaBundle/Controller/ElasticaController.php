<?php

namespace Acme\ElasticaBundle\Controller;

use Acme\ElasticaBundle\Model\ProductSearch;
use Elastica\Document;
use Elastica\Query;
use FOS\ElasticaBundle\Elastica\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Acme\ElasticaBundle\Form\Type\ProductSearchType;
use Symfony\Component\Form\Forms;

class ElasticaController extends FOSRestController
{

    public function searchProductAction()
    {
        $finder = $this->container->get('fos_elastica.finder.acme_elastica.product');

        $boolQuery = new Query\Bool();

        $fieldQuery = new Query\Match();
        $fieldQuery->setFieldQuery('name', 'update2');
        $boolQuery->addMust($fieldQuery);

        $tagsQuery = new Query\Terms();
        $tagsQuery->setTerms('price', array('55'));
        $boolQuery->addMust($tagsQuery);

        $data = $finder->find($boolQuery);

        $serializer = SerializerBuilder::create()->build();

        $jsonContent = $serializer->serialize($data,'json');

        return new Response($jsonContent);

    }

    public function indexAction(Request $request)
    {
        $productSearch = new ProductSearch();

        $form = $this->createForm(new ProductSearchType(),$productSearch,array(
            'action' => $this->generateUrl('acme_elastica_index',array(
                '_format' => 'html',
            )),
            'method' => 'GET'
        ));

        $form ->handleRequest($request);
        $productSearch = $form->getData();

        $elasticaManager = $this->container->get('fos_elastica.manager');
        $results = $elasticaManager->getRepository('AcmeProductBundle:Product');
        $data = $results->search($productSearch);

        return $this->render('AcmeElasticaBundle:Product:list.html.twig',array(
            'results' => $data,
            'form' => $form->createView(),
        ));
    }

    //hard coded document,just for tests
    public function createProductAction()
    {
        $client = new Client();
        $index = $client->getIndex('acme_elastica');
        $type = $index->getType('product');

        $type->addDocument(new Document('',array(
            "name" => "product6",
            "description" => "item created from controller",
            "price" => "33",
        )));
        $index->refresh();

        return new Response('new document created');
    }

    public function updateProductAction()
    {

        $client = new Client();
        $index = $client->getIndex('acme_elastica');
        $type = $index->getType('product');

        $document = $type->getDocument('555b4bc849ee12dc0b0041a8');

        $document->set('name','update2');

        $type->addDocument($document);
        $index->refresh();

        //to delete an item you need to do this:
        //$type->deleteById("id");

        $serializer = SerializerBuilder::create()->build();

        $jsonContent = $serializer->serialize($document,'json');

        return new Response($jsonContent);
    }

}
