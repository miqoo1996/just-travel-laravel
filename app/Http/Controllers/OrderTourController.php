<?php

namespace App\Http\Controllers;

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
                $order->tour = $order->tour();
                if(null !== $order->hotel_id) {
                    $order->days = $order->customDays();
                    $order->hotel = $order->hotel();
                    $order->tour_hotel = $order->tourHotel();
                    $rooms = HotelCalculator::calc($order->adult, $order->child, $order->infant);
                    return view('order_tour', compact('order', 'rooms'));
                }
                $totalPrice = $order->tour['basic_price_adult'] * $order->adult + $order->tour['basic_price_child'] * $order->child + $order->tour['basic_price_infant'] * $order->infant;
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
        ];

        $validator = Validator::make($request->input(), $rules, $messages);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator);
        }
        
    }

    public function postOrderedBasicTour(Request $request)
    {
        dd($request->input());
    }
}
