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

            $response = $api->rest('GET', '/admin/orders.json', 
                [
                    'limit' => 5, 
                    'created_at_max' => '2021-10-01T15%3A22%3A00-04%3A00',
                    'created_at_min' => '2021-09-30T15%3A22%3A00-04%3A00',
                    'status' => 'any'
                ]
                );
            $orders = $response['body']['container']['orders'];



             // output headers so that the file is downloaded rather than displayed
        // header('Content-type: text/csv');
        // header('Content-Disposition: attachment; filename="demo.csv"');
        
        // // do not cache the file
        // header('Pragma: no-cache');
        // header('Expires: 0');
 
        // // create a file pointer connected to the output stream
        // $file = fopen('php://output', 'w');
        
        // // send the column headers
        // fputcsv($file, array('ID', 'NAME', 'TIME', 'LASTNAME', 'EMAIL', 'TOTAL', 'TTC'));
        
        // $data =[];
        // $total_tax = 0;
        // foreach($orders as $order){
        //     $data[] = [
        //         $order['id'],
        //         $order['name'],
        //         $order['created_at'],
        //         $order['customer']['last_name'],
        //         $order['email'],
        //         $order['total_price'],
        //         $order['total_price']+$order['total_tax']
        //     ];
        //     foreach($order['tax_lines'] as $tax){
        //         // if($tax['title'] == 'FR TVA'){  
        //             $total_tax += $tax['price'];
        //         // }
        //     }
        // }
        // $data[] = [];
        // $data[] = [ 'TOTAL TAX', $total_tax];

        // // output each row of the data
        // foreach ($data as $row)
        // {
        //     fputcsv($file, $row);
        // }
        // exit();
        


        return $this->render('testUniq/welcometest.html.twig', [
            'data' => $data,
            'products' => $response
        ]);
    }
}