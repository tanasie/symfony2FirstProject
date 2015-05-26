<?php

namespace Acme\ProductBundle\Repository;

use Elastica\Document;
use Elastica\Filter\Bool;
use Elastica\Filter\Range;
use Elastica\Query\Filtered;
use Elastica\Query\MatchAll;
use FOS\ElasticaBundle\Elastica\Client;
use FOS\ElasticaBundle\Repository;
use Acme\ElasticaBundle\Model\ProductSearch;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Elastica\Request;

class ProductRepository extends Repository
{
    public function search(ProductSearch $productSearch)
    {

        $client = new Client();
        $index = $client->getIndex('acme_elastica');
        $type = $index->getType('product');

        $query = array(
            'query' => array(
                'multi_match' => array(
                    'query'    => '',
                    'type'     => 'cross_fields',
                    'fields'   => array(),
                    'operator' => 'and',
                )
            )
        );

        if ($productSearch->getName() != null && $productSearch != '') {
            $query['query']['multi_match']['query'] .= ' ' . $productSearch->getName();
            $query['query']['multi_match']['fields'][] = 'name';
        }
        if ($productSearch->getDescription() != null && $productSearch != '') {
            $query['query']['multi_match']['query'] .= ' ' . $productSearch->getDescription();
            $query['query']['multi_match']['fields'][] = 'description';
        }
        if ($productSearch->getPrice() != null && $productSearch != '') {
            $query['query']['multi_match']['query'] .= ' ' . $productSearch->getPrice();
            $query['query']['multi_match']['fields'][] = 'price';
        }


        $path = $index->getName() . '/' . $type->getName() . '/_search';
        $response = $client->request($path, Request::GET, $query);
        $responseArray = $response->getData();

        return $responseArray;

    }

}



