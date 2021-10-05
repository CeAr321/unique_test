<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Osiset\BasicShopifyAPI\BasicShopifyAPI;
use Osiset\BasicShopifyAPI\Options;
use Osiset\BasicShopifyAPI\Session;



class DefaultController extends AbstractController
{
    public function index(): Response
    {
        // ************************************************
        // 1) se connecter aux APIs de la boutique Shopify
            $data = $this->getParameter('app.shop_name');
            $api_key = $this->getParameter('app.shop_api_key');
            $api_secret = $this->getParameter('app.shop_api_secret');
            $shop = $this->getParameter('app.shop_name');
            $api_token = $this->getParameter('app.shop_api_token');

            // Create options for the API
            $options = new Options();
            $options->setVersion('2020-01');

            // Create the client and session
            $api = new BasicShopifyAPI($options);
            $api->setSession(new Session($shop, $api_token));
        // ETAPE 1 : DONE !!!
        // ************************************************

            $response = $api->rest('GET', '/admin/products.json', ['limit' => 5]);
            $products = $response['body']['container']['products'];


        return $this->render('testUniq/welcometest.html.twig', [
            'data' => $data,
            'products' => $products
        ]);
    }
}