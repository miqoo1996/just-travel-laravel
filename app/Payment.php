<?php

namespace App;

use Barryvdh\DomPDF\Facade as PDF;
use FontLib\EOT\File;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use Endroid\QrCode\QrCode;
use Illuminate\Support\Facades\File as Files;
use Illuminate\Support\Facades\Session;


class Payment extends Model
{
    private static $userName = 'converse_test';
    private static $password = 'password123456';

    protected $fillable = [
        'loc_amount',
        'expiration',
        'cardholderName',
        'depositAmount',
        'currency',
        'approvalCode',
        'authCode',
        'ErrorCode',
        'ErrorMessage',
        'OrderStatus',
        'OrderNumber',
        'Pan',
        'Amount',
        'Ip',
        'SvfeResponse'
    ];
    public static function makeOrder($orderTour)
    {
//        $amount = number_format((float)$orderTour->amount, 2, '.', '');
        $returnUrl = url('/congratulations');
        $language = app()->getLocale();
        $amount = $orderTour->amount * 100;
        $description = str_limit(strip_tags($orderTour->tour->{'desc_'.$language}), $limit = 100, $end = '...');
        $uri = '/payment/rest/register.do?userName='.self::$userName.'&password='.self::$password.'&amount='. $amount .'&currency=051&language='.$language.'&orderNumber='.$orderTour->order_id.'&description='.$description.'&returnUrl='.$returnUrl;
        $client = new Client(['base_uri' => 'https://ipaytest.arca.am:8445', 'verify'=> false]);
        $response = $client->request('get',$uri)->getBody()->getContents();
        $response = json_decode($response, true);
        if(array_key_exists('formUrl', $response)){
            $orderTour->md_order = $response['orderId'];
            $orderTour->save();
            $data['status'] = true;
            $data['url'] = $response['formUrl'];
            Session::set('payFormUrl', $response['formUrl']);
        } else {
            if (Session::get('payOrder') === true) {
                $data['status'] = true;
                $data['url'] = Session::get('payFormUrl');
            } else {
                $data['status'] = false;
            }
            $data['content'] = $response;
        }
        Session::set('payOrder', $data['status']);
        return $data;
    }

    public static function checkOrder($orderId){
        $uri = '/payment/rest/getOrderStatus.do?orderId='.$orderId.'&password='.self::$password.'&userName='.self::$userName;
        $client = new Client(['base_uri' => 'https://ipaytest.arca.am:8445', 'verify'=> false]);
        $response = $client->request('get',$uri)->getBody()->getContents();
        $response = json_decode($response, true);
        return $response;
    }

    public static function generateAndSendVоucher($order)
    {

        $storePath = storage_path('vouchers');
        $qrCode = new QrCode();
        $qrText = self::generateQrText($order);
            $qrCode->setText($qrText)
            ->setErrorCorrectionLevel('low')
            ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
            ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
            ->setWriterByName('png');

        $qrCode->writeFile('images/qr/'.$order->id.'_qrcode.png');
        $generatedFile = PDF::loadView('pdf.voucher', compact('order'));
        $generatedFile->save($storePath.'/'.$order->id.'.pdf');
//        Files::delete('images/qr/'.$order->id.'_qrcode.png');
    }

    public static function generateQrText($order)
    {
        $qrText = "Travelers lead - " . $order['lead_name'] . ' ' . $order['lead_name'] . "\n";
        $qrText .= "Contact - " . $order['lead_email'] . "\n";
        $qrText .= "Travelers count - " . count($order['members']) . "\n";
        $qrText .= "Tour - " . $order['tour']['tour_name_en'] . "\n";
        $qrText .= "Tour Date - " . $order['date_from'] . "\n";
        $qrText .= "Tour Price - " . $order['amount'] . " AMD \n";
        return $qrText;
    }
}
