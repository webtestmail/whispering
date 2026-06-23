<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Mail\ContactMail;
use App\Mail\ContactVerificationMail;
use Illuminate\Support\Facades\Cache;
use App\Models\Contact;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{


private function verifyCaptcha($token, $ip)
{
    $response = \Illuminate\Support\Facades\Http::asForm()->post(
        'https://www.google.com/recaptcha/api/siteverify',
        [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $token,
            'remoteip' => $ip,
        ]
    );

    return $response->json()['success'] ?? false;
}

    public function submit(Request $request)
{
   $request->validate([
    'name' => 'required',
    'email' => 'required',
      'g-recaptcha-response' => 'required'
   ]);

    if (!$this->verifyCaptcha($request->input('g-recaptcha-response'), $request->ip())) {
        return response()->json([
            'errors' => ['captcha' => ['Captcha verification failed']]
        ], 422);
    }
   $data = [
    'name' => $request->name,
    'email' => $request->email,
    'subject' => $request->subject,
    'message' => $request->message,
   ];
   
   

    Contact::create($data);  // Save to DB

    // Send admin notification
   Mail::to('webtestmail736@gmail.com')  // Replace with your email
    ->send(new ContactMail($data));


    return response()->json(['success' => 'Form submitted successfully! Thank you.']);
}

}