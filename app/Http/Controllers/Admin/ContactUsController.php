<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ContactQueries;
use Illuminate\Support\Facades\Mail;
class ContactUsController extends Controller
{
    public function index(Request $request)
    {

        $queries = ContactQueries::all();
        return view('admin.contactus.index',compact('queries'));
    }

    public function deleteQueries(Request $request){

        if($request->ids)
        {
            $res =  ContactQueries::whereIn('id', $request->ids)->delete();

            if($res)
            {
                return response()->json(['status'=>true,'mesg'=>'Deleted Successfully']);
            }
        }
    }

    public function submitQuery(Request $request){

//        dd($request->all());
        $request->validate([
            'name' => 'required',
            'email'=>'required',
            'phone'=>'required',
            'subject'=>'required',
            'message'=>'required',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        ContactQueries::create($request->all());

        $to = $request->email;
        $mesg = 'Dear Customer ,
            Thank you for contacting with us.
            Our Support Team will contact you back soon.
            Thanks.
            THE OPULENCE';
        Mail::raw($mesg, function ($message) use ($to){
            $message->to($to)
                ->subject('Auto Reply')
                ->from('no-reply@opulence.com', $name = "no-reply@opulence.com");
        });

        return back()->with('success-mesg','Your Query Submitted Successfully !! ');
    }
}
