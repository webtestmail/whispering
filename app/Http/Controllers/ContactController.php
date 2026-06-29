<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Mail\NewsletterWelcome;
use App\Models\Admin\Company;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    private function verifyCaptcha(?string $token, string $ip): bool
    {
        if (! config('services.recaptcha.secret_key') || ! $token) {
            return false;
        }

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

    private function adminEmail(): string
    {
        $company = Company::select('email', 'alternate_email')->first();

        return $company?->email
            ?: $company?->alternate_email
            ?: config('mail.from.address');
    }

    public function submit(Request $request)
    {
        $formType = $request->input('form_type', 'contact');

        $rules = [
            'form_type' => 'nullable|in:contact,booking,newsletter',
        ];

        if ($formType === 'newsletter') {
            $rules['email'] = 'required|email';
        } else {
            $rules['name'] = 'required|string|max:255';
            $rules['email'] = 'required|email';
            $rules['phone'] = 'nullable|string|max:50';
            $rules['message'] = 'nullable|string|max:5000';
            $rules['guests'] = 'nullable|string|max:50';
            $rules['checkin'] = 'nullable|date';
            $rules['checkout'] = 'nullable|date|after_or_equal:checkin';
            $rules['nights'] = 'nullable|string|max:50';
            $rules['subject'] = 'nullable|string|max:255';
        }

        if (config('services.recaptcha.site_key') && $formType === 'contact') {
            $rules['g-recaptcha-response'] = 'required';
        }

        $request->validate($rules);

        if (config('services.recaptcha.site_key') && $formType === 'contact') {
            if (! $this->verifyCaptcha($request->input('g-recaptcha-response'), $request->ip())) {
                return response()->json([
                    'errors' => ['captcha' => ['Captcha verification failed. Please try again.']],
                ], 422);
            }
        }

        if ($formType === 'newsletter') {
            $existing = Contact::where('form_type', 'newsletter')
                ->where('email', $request->email)
                ->exists();

            if ($existing) {
                return response()->json(['success' => 'You are already subscribed. Thank you!']);
            }

            $data = [
                'form_type' => 'newsletter',
                'name' => 'Newsletter Subscriber',
                'email' => $request->email,
                'subject' => 'Newsletter Subscription',
                'message' => 'Subscribed via website newsletter form.',
                'status' => 'new',
            ];
        } else {
            $subject = $request->subject ?: match ($formType) {
                'booking' => 'Booking Enquiry',
                default => 'Contact Enquiry',
            };

            $data = [
                'form_type' => $formType,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $subject,
                'message' => $request->message,
                'guests' => $request->guests,
                'checkin' => $request->checkin,
                'checkout' => $request->checkout,
                'nights' => $request->nights,
                'status' => 'new',
            ];
        }

        Contact::create($data);

        $adminEmail = $this->adminEmail();

        if ($formType === 'newsletter') {
            Mail::to($request->email)->send(new NewsletterWelcome($request->email));
            Mail::to($adminEmail)->send(new ContactMail($data));
        } else {
            Mail::to($adminEmail)->send(new ContactMail($data));
        }

        return response()->json(['success' => 'Form submitted successfully! Thank you.']);
    }
}
