<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;


class Payment extends Model
{
    public static function makeOrder($orderTour)
    {
//        $uri = '/register.do?userName=converse_test&password=password123456&amount='. $orderTour->amount .'&currency=051&language='.app()->getLocale().'&orderNumber='.$orderTour->order_id.'&returnUrl=http://justtravel.dev/';
//        $client = new Client(['base_uri' => 'https://ipaytest.arca.am', 'verify'=> false]);
//        $response = $client->request('get',$uri)->getBody();
//        return $response;

//        $client = new Client(['verify'=> false]);
//        $url = 'https://ipaytest.arca.am';
//
//        $body['userName'] = 'converse_test';
//        $body['password'] = 'password123456';
//        $body['amount'] = $orderTour->amount;
//        $body['currency'] = '051';
//        $body['language'] = app()->getLocale();
//        $body['orderNumber'] = $orderTour->order_id;
//        $body['returnUrl'] = 'http://justtravel.dev';
//
//        $response = $client->post($url, $body);
//        dd($response);
    }
}
