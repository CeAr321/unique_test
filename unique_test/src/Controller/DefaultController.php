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

            $response = $api->rest('GET', '/admin/orders.json', ['limit' => 5]);
            $orders = $response['body']['container']['orders'];



             // output headers so that the file is downloaded rather than displayed
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="demo.csv"');
        
        // do not cache the file
        header('Pragma: no-cache');
        header('Expires: 0');
 
        // create a file pointer connected to the output stream
        $file = fopen('php://output', 'w');
        
        // send the column headers
        fputcsv($file, array('ID', 'NAME', 'TIME', 'LASTNAME', 'EMAIL', 'TOTAL', 'TTC'));
        
        // Sample data. This can be fetched from mysql too
        // $data = array(
        // array('Data 11', 'Data 12', 'Data 13', 'Data 14', 'Data 15'),
        // array('Data 21', 'Data 22', 'Data 23', 'Data 24', 'Data 25'),
        // array('Data 31', 'Data 32', 'Data 33', 'Data 34', 'Data 35'),
        // array('Data 41', 'Data 42', 'Data 43', 'Data 44', 'Data 45'),
        // array('Data 51', 'Data 52', 'Data 53', 'Data 54', 'Data 55')
        // );
        $data =[];
        foreach($orders as $order){
            $data[] = [
                $order['id'],
                $order['name'],
                $order['created_at'],
                $order['customer']['last_name'],
                $order['email'],
                $order['total_price'],
                $order['total_price']+$order['total_tax']

            ];
        }

        // output each row of the data
        foreach ($data as $row)
        {
        fputcsv($file, $row);
        }
        exit();
        


        return $this->render('testUniq/welcometest.html.twig', [
            'data' => $data,
            'products' => $response
        ]);
    }
}