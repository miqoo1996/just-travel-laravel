<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;


class Payment extends Model
{
    public static function makeOrder($orderTour)
    {
//        $amount = number_format((float)$orderTour->amount, 2, '.', '');
        $returnUrl = url('/congratulations');
        $amount = $orderTour->amount * 100;
        $uri = '/payment/rest/register.do?userName=converse_test&password=password123456&amount='. $amount .'&currency=051&language='.app()->getLocale().'&orderNumber='.$orderTour->order_id.'&returnUrl='.$returnUrl;
        $client = new Client(['base_uri' => 'https://ipaytest.arca.am:8445', 'verify'=> false]);
        $response = $client->request('get',$uri)->getBody()->getContents();
        $response = json_decode($response, true);
        if(array_key_exists('formUrl', $response)){
            $orderTour->md_order = $response['orderId'];
            $orderTour->save();
            return $response['formUrl'];
        }
        return false;

//        $client = new Client(['verify'=> false]);
//        $url = 'https://ipaytest.arca.am:8445/payment/rest/register.do';
//
//        $body['userName'] = 'converse_test';
//        $body['password'] = 'password123456';
//        $body['amount'] = 5000;
//        $body['currency'] = 051;
//        $body['language'] = 'en';
//        $body['orderNumber'] = 64118716;
//        $body['returnUrl'] = 'http://justtravel.dev';
//
//        $response = $client->post($url, $body)->getBody()->getContents();
//        dd($response);
    }
}