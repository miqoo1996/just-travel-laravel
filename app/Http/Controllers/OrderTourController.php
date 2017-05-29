<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderMember;
use App\Payment;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use App\HotelCalculator;
use App\OrderTour;
use Illuminate\Support\Facades\Validator;


class OrderTourController extends Controller
{
    public function postOrderTour(Request $request)
    {
        $uniqId = uniqid();
        if (Session::has('order_tour')) {
            $orderTour = Session::get('order_tour');
            Session::flush('order_tour');
            Session::set('order_tour', $orderTour . '/' . $uniqId);
        } else {
            Session::set('order_tour',  $uniqId);

        }
        $newOrder = new OrderTour();
        $newOrder->fill($request->input());
        $newOrder->hotel_id = $request->htdata;
        $newOrder->order_id = $uniqId;
        $newOrder->save();
        if($request->ajax()) {
            return $uniqId;
        }
        return redirect('order_tour/'.$uniqId);
    }

    public function getOrderTour($order_id){
        if(Session::has('order_tour')){
            $orderTour = Session::get('order_tour');
            $orderTour = array_flip(explode('/', $orderTour));
            if(isset($orderTour[$order_id])){
                $order = OrderTour::where('order_id', $order_id)->first();
                $saveOrder = clone $order;
                $order->tour = $order->tour();
                if(null !== $order->hotel_id) {
                    $order->days = $order->customDays();
                    $order->hotel = $order->hotel();
                    $order->tour_hotel = $order->tourHotel();
                    $rooms = HotelCalculator::calc($order->adult, $order->child, $order->infant);

                    $adultPrice = $order->tour_hotel[config('const.adult_key_' . strval($order->adult)) . '_adult']  * $order->days;
                    $childPrice = $order->tour_hotel['child'] * $order->days * $order->child;
                    $infantPrice = $order->tour_hotel['infant'] * $order->days * $order->infant;

                    $totalPrice = $adultPrice + $childPrice + $infantPrice;
                    $saveOrder->amount = $totalPrice;
                    $saveOrder->rooms = $rooms;
                    $saveOrder->save();
                    return view('order_tour', compact('order', 'rooms', 'totalPrice'));
                }
                $totalPrice = $order->tour['basic_price_adult'] * $order->adult + $order->tour['basic_price_child'] * $order->child + $order->tour['basic_price_infant'] * $order->infant;
                $saveOrder->amount = $totalPrice;
                $saveOrder->save();
                return view('order_basic_tour', compact('order', 'totalPrice'));
            }
        }
        return redirect('404');
    }

    public function postOrderedCustomTour(Request $request)
    {
        $rules = [
            'adult_name.*' => 'required',
            'adult_surname.*' => 'required',
//            'adult_birth_date.*' => 'required|date|date_format:dd/mm/Y|before:12Y',
            'adult_birth_date.*' => 'required',
            'child_name.*' => 'required',
            'child_surname.*' => 'required',
//            'child_birth_date.*' => 'required|date|date_format:dd/mm/Y|before:4Y',
            'child_birth_date.*' => 'required',
            'infant_name.*' => 'required',
            'infant_surname.*' => 'required',
//            'infant_birth_date.*' => 'required|date|date_format:dd/mm/Y|before:yesterday',
            'infant_birth_date.*' => 'required',
            'lead_email' => 'required|email'

        ];
        $lang = app()->getLocale();
        $messages = [
            'adult_name.*.required' => config('validation.'.$lang.'.adult_name_required'),
            'child_name.*.required' => config('validation.'.$lang.'.child_name_required'),
            'infant_name.*.required' => config('validation.'.$lang.'.infant_name_required'),
            'adult_surname.*.required' => config('validation.'.$lang.'.adult_surname_required'),
            'child_surname.*.required' => config('validation.'.$lang.'.child_surname_required'),
            'infant_surname.*.required' => config('validation.'.$lang.'.infant_surname_required'),
            'adult_birth_date.*.required' => config('validation.'.$lang.'.adult_birth_date_required'),
            'adult_birth_date.*.date' => config('validation.'.$lang.'.adult_birth_date_date'),
            'child_birth_date.*.required' => config('validation.'.$lang.'.child_birth_date_required'),
            'child_birth_date.*.date' => config('validation.'.$lang.'.child_birth_date_date'),
            'infant_birth_date.*.required' => config('validation.'.$lang.'.infant_birth_date_required'),
            'infant_birth_date.*.date' => config('validation.'.$lang.'.infant_birth_date_date'),
            'lead_email.required' => config('validation.'.$lang.'.lead_email_required'),
            'lead_email.email' => config('validation.'.$lang.'.lead_email_email'),
        ];

        $validator = Validator::make($request->input(), $rules, $messages);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $orderTour = OrderTour::where('order_id', $request->order_id)->first();
        $orderTour->lead_email = $request->lead_email;
        $orderTour->comment = $request->comment;
        $orderTour->save();
        foreach ($request->adult_name as $key => $value){
            $member['member_name'] = $value;
            $member['member_surname'] = $request->adult_surname[$key];
            $member['member_dob'] = $request->adult_birth_date[$key];
            $member['member_prp'] = 'adult';
            $member['order_id'] = $orderTour->id;
            $data[] = $member;
        }
        if(count($request->child_name)){
            foreach ($request->child_name as $key => $value){
                $member['member_name'] = $value;
                $member['member_surname'] = $request->child_surname[$key];
                $member['member_dob'] = $request->child_birth_date[$key];
                $member['member_prp'] = 'child';
                $member['order_id'] = $orderTour->id;
                $data[] = $member;
            }
        }
        if(count($request->infant_name)) {

            foreach ($request->infant_name as $key => $value) {
                $member['member_name'] = $value;
                $member['member_surname'] = $request->infant_surname[$key];
                $member['member_dob'] = $request->infant_birth_date[$key];
                $member['member_prp'] = 'infant';
                $member['order_id'] = $orderTour->id;
                $data[] = $member;
            }
        }
        OrderMember::where('order_id', $orderTour->id)->delete();
        if(isset($data)){ OrderMember::insert($data);}
        return redirect('/payment/'. $orderTour->order_id);
//
    }

    public function getPaymentByOrderId($order_id)
    {
        $orderTour = OrderTour::where('order_id', $order_id)->first();
        if(null == $orderTour) {return redirect('404');}
        else {
            $view = 'payment_basic';
            $orderTour->tour = $orderTour->tour();
            if(null !== $orderTour->hotel_id) {
                $orderTour->hotel = $orderTour->hotel();
                $view = 'payment';
            }
            $orderTour->members = $orderTour->members();
        }
        return view($view, compact('orderTour'));
    }
    public function postOrderedBasicTour(Request $request)
    {
        dd($request->input());
    }

    public function postPay(Request $request)
    {
        $orderTour = OrderTour::where('order_id', $request->order_id)->first();
        $url = Payment::makeOrder($orderTour);
        if($url){
            return redirect($url);
        }
        Session::flash('payment_error', 'Payment Failed');
        return redirect('/');
    }

    public function getCongratulations()
    {
        if(request()->has('orderId')) {
            $order = OrderTour::where('md_order', request()->orderId)->first();
            if(null == $order){
                return redirect('404');
            }
            $orderStatus = Payment::checkOrder(request()->orderId);
                if (Session::has('order_tour')){
                    $orderSession = Session::get('order_tour');
                    $orderSession = str_replace('/'.$order->order_id, '', $orderSession);
                    $orderSession = str_replace($order->order_id . '/', '', $orderSession);
                    $orderSession = str_replace($order->order_id, '', $orderSession);
                    $orderSession = str_replace('//', '/', $orderSession);
                    Session::put('order_tour', $orderSession);
                }
                dd($orderStatus);
            $order['tour'] = $order->tour();


            return view('congratulations', compact('order'));
        }
        return redirect('404');
    }
}
