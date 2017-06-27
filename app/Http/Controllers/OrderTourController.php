<?php

namespace App\Http\Controllers;

use App\Payment;
use App\TourDate;
use App\OrderTour;
use App\OrderMember;
use App\HotelCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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
            Session::set('order_tour', $uniqId);
        }

        $date = $request->get('date_from');
        $tour_id = intval($request->get('tour_id', 0));
        if ($date && $tour_id) {
            $date = date("Y-m-d", strtotime($date));
            $isTourDate = (bool)TourDate::where('tour_id', $tour_id)->where('date', $date)->get()->count();
            if (!$isTourDate) {
                $newOrder = new OrderTour();
                $newOrder->fill($request->input());
                $newOrder->hotel_id = $request->htdata;
                $newOrder->order_id = $uniqId;
                $newOrder->save();
                if ($request->ajax()) {
                    return $uniqId;
                }
                return redirect('order_tour/' . $uniqId);
            }
        }
        return back();
    }

    public function getOrderTour($order_id)
    {
        if (Session::has('order_tour')) {
            $orderTour = Session::get('order_tour');
            $orderTour = array_flip(explode('/', $orderTour));
            if (isset($orderTour[$order_id])) {
                $order = OrderTour::with(config('relations.order_tour_all'))->where('order_id', $order_id)->first();
                if (!$order->tourHotel->isEmpty()) {
                    $rooms = HotelCalculator::calc($order->adults_count, $order->children_count, $order->infants_count);
                    $hotel = $order->tourHotel->where('tour_id', $order->tour_id)->first()->toArray();
                    $adultPrice = $hotel[config('const.adult_key_' . $order->adults_count)];
                    $childPrice = $hotel['child'] * $order->children_count;
                    $infantPrice = $hotel['infant'] * $order->infants_count;
                    $totalPrice = $adultPrice + $childPrice + $infantPrice;
                    $order->amount = $totalPrice;
                    $order->rooms = $rooms;
                    $saveFields['order_tour.amount'] = $totalPrice;
                    $saveFields['order_tour.rooms'] = $rooms;
                    $order->fill($saveFields);
                    $order->save();
                    return view('order_tour', compact('order', 'rooms', 'totalPrice'));
                } else {
                    $totalPrice = floatval($order->tour->basic_price_adult * $order->adults_count + $order->tour->basic_price_child * $order->children_count + $order->tour->basic_price_infant * $order->infants_count);
                    $order->amount = $totalPrice;
                    $saveFields['order_tour.amount'] = $totalPrice;
                    $order->fill($saveFields);
                    $order->save();
//                    dd($order);
                    return view('order_basic_tour', compact('order', 'totalPrice'));
                }
            }
        }
        return redirect('404');
    }

    public function postOrderedCustomTour(Request $request)
    {
        $rules = [
            'adult_name.*' => 'required|max:255',
            'adult_surname.*' => 'required',
//            'adult_birth_date.*' => 'required|date|date_format:dd/mm/Y|before:12Y',
            'adult_birth_date.*' => 'required',
            'child_name.*' => 'required|max:255',
            'child_surname.*' => 'required|max:255',
//            'child_birth_date.*' => 'required|date|date_format:dd/mm/Y|before:4Y',
            'child_birth_date.*' => 'required',
            'infant_name.*' => 'required|max:255',
            'infant_surname.*' => 'required|max:255',
//            'infant_birth_date.*' => 'required|date|date_format:dd/mm/Y|before:yesterday',
            'infant_birth_date.*' => 'required',
            'lead_email' => 'required|email'

        ];
        $lang = app()->getLocale();
        $messages = [
            'adult_name.*.required' => config('validation.' . $lang . '.adult_name_required'),
            'child_name.*.required' => config('validation.' . $lang . '.child_name_required'),
            'infant_name.*.required' => config('validation.' . $lang . '.infant_name_required'),
            'adult_surname.*.required' => config('validation.' . $lang . '.adult_surname_required'),
            'child_surname.*.required' => config('validation.' . $lang . '.child_surname_required'),
            'infant_surname.*.required' => config('validation.' . $lang . '.infant_surname_required'),
            'adult_birth_date.*.required' => config('validation.' . $lang . '.adult_birth_date_required'),
            'adult_birth_date.*.date' => config('validation.' . $lang . '.adult_birth_date_date'),
            'child_birth_date.*.required' => config('validation.' . $lang . '.child_birth_date_required'),
            'child_birth_date.*.date' => config('validation.' . $lang . '.child_birth_date_date'),
            'infant_birth_date.*.required' => config('validation.' . $lang . '.infant_birth_date_required'),
            'infant_birth_date.*.date' => config('validation.' . $lang . '.infant_birth_date_date'),
            'lead_email.required' => config('validation.' . $lang . '.lead_email_required'),
            'lead_email.email' => config('validation.' . $lang . '.lead_email_email'),
        ];

        $validator = Validator::make($request->input(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $orderTour = OrderTour::where('order_id', $request->order_id)->first();
        $orderTour->lead_email = $request->lead_email;
        $orderTour->lead_name = $request->adult_name[1];
        $orderTour->lead_surname = $request->adult_surname[1];
        $orderTour->comment = $request->comment;
        $orderTour->save();
        if (isset($request->adult_name) && is_array($request->adult_name)) {
            foreach ($request->adult_name as $key => $value) {
                $member['member_name'] = $value;
                $member['member_surname'] = $request->adult_surname[$key];
                $member['member_dob'] = $request->adult_birth_date[$key];
                $member['member_prp'] = 'adult';
                $member['order_tour_id'] = $orderTour->id;
                $data[] = $member;
            }
        }
        if (isset($request->child_name) && is_array($request->child_name)) {
            if (count($request->child_name)) {
                foreach ($request->child_name as $key => $value) {
                    $member['member_name'] = $value;
                    $member['member_surname'] = $request->child_surname[$key];
                    $member['member_dob'] = $request->child_birth_date[$key];
                    $member['member_prp'] = 'child';
                    $member['order_tour_id'] = $orderTour->id;
                    $data[] = $member;
                }
            }
        }
        if (isset($request->infant_name) && is_array($request->infant_name)) {
            if (count($request->infant_name)) {
                foreach ($request->infant_name as $key => $value) {
                    $member['member_name'] = $value;
                    $member['member_surname'] = $request->infant_surname[$key];
                    $member['member_dob'] = $request->infant_birth_date[$key];
                    $member['member_prp'] = 'infant';
                    $member['order_tour_id'] = $orderTour->id;
                    $data[] = $member;
                }
            }
        }
        OrderMember::where('order_tour_id', $orderTour->id)->delete();
        if (isset($data)) {
            OrderMember::insert($data);
        }
        return redirect('/payment/' . $orderTour->order_id);
    }

    public function getPaymentByOrderId($order_id)
    {
        $orderTour = OrderTour::with(config('relations.order_tour_all'))->where('order_id', $order_id)->first();
        if (null == $orderTour) {
            return redirect('404');
        } else {
            $view = 'payment_basic';
            if (!$orderTour->tourHotel->isEmpty()) {
                $view = 'payment';
            }
            $orderTour->members;
        }
        return view($view, compact('orderTour'));
    }

    public function postPay(Request $request)
    {
        $orderTour = OrderTour::where('order_id', $request->order_id)->first();
        $response = Payment::makeOrder($orderTour);
        if ($response['status']) {
            return redirect($response['url']);
        }
        $message = isset($response['content']['errorMessage']) ? $response['content']['errorMessage'] : 'Error';
        return view('payment_error', compact('message'));
    }

    public function getCongratulations()
    {
        if (request()->has('orderId')) {
            $order = OrderTour::with(['tour', 'members'])->where('md_order', request()->orderId)->first();
            if (null == $order) {
                return redirect('404');
            }
            $orderStatus = Payment::checkOrder(request()->orderId);
            if (Session::has('order_tour')) {
                $orderSession = Session::get('order_tour');
                $orderSession = str_replace('/' . $order->order_id, '', $orderSession);
                $orderSession = str_replace($order->order_id . '/', '', $orderSession);
                $orderSession = str_replace($order->order_id, '', $orderSession);
                $orderSession = str_replace('//', '/', $orderSession);
                Session::put('order_tour', $orderSession);
            }
            $payment = new Payment();
            $payment->fill($orderStatus);
            $payment->order_tour_id = $order->id;
            $payment->save();

            if (($errorCode = $payment->ErrorCode == '0') && ($orderStatus = $payment->OrderStatus == '2')) {
                Payment::generateAndSendVоucher($order);
                return view('congratulations', compact('order', 'image'));
            }

            $message = 'Error';
            if ($errorCode == false) {
                $message = trans(sprintf('messages.ErrorCode.%s', $payment->ErrorCode));
            }
            if ($orderStatus == false) {
                $message = trans(sprintf('messages.OrderStatus.%s', $payment->OrderStatus));
            }

            return view('payment_error', compact('message'));
        }
        return redirect('404');
    }

}
