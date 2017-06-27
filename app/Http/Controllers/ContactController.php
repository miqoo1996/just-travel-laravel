<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function getContacts()
    {
        return view('contacts');
    }

    public function postContacts(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'name' => 'required',
            'message' => 'required'
        ];

        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            return redirect()->back()->withErrors($validator);
        }

        $contact = new Contact();
        $contact->fill($request->input());
        $contact->save();
        Session::flash('thx', 'ok');
        return redirect()->back();
    }
}
