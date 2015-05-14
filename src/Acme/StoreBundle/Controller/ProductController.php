<?php

namespace Acme\StoreBundle\Controller;

use Acme\StoreBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\StoreBundle\Document\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProductController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeStoreBundle:Default:index.html.twig', array('name' => $name));
    }
    /**
     * Create a new Product
     */
    public function createProductAction(Request $request)
    {
        /** @var Product $product */

        $product = new Product();
        $form   = $this->createForm(new ProductType(), $product);

        $form->handleRequest($request);

        if($form->isValid())
        {

            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($product);
            $dm->flush();

            return $this->redirectToRoute('acme_show_product',array(
                'id' => $product->getId()
            ));

        }
        return $this->render('AcmeStoreBundle:Product:new.html.twig', array(
            'form'   => $form->createView()
        ));

    }

    /**
     * @param $id
     * @return Response
     */
    public function showProductAction($id)
    {
        $product = $this->get('doctrine_mongodb')
            ->getRepository('AcmeStoreBundle:Product')
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException('No product found for id '.$id);
        }
        var_dump($product);exit;
        return $this->render('AcmeStoreBundle:Product:showProduct.html.twig', array(
            'product'   => $product
        ));
    }

    /**
     * @Template()
     */
    public function showAllProductsAction()
    {
        /**
         * @var Product $products
         */

        $products = $this->get('doctrine_mongodb')
            ->getRepository('AcmeStoreBundle:Product')
            ->findAll();

        return array(
          'products' => $products,
        );
    }

    /**
     * @param $name
     * @Template()
     */
    public function getAllProductsByNameAction($name)
    {
        /** @var Product $products */
        $products = $this->get('doctrine_mongodb')
                    ->getRepository('AcmeStoreBundle:Product')
                    ->findByName($name);

        return array(
            'products' => $products,
        );
    }
}
