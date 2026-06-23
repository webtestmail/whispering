<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetPassword;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    
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

    use SendsPasswordResetEmails;
    
    
    public function password_request()
    {
        return view('auth.forget'); // Ensure this view exists
    }
    
    public function resetpasswordpage($id){
        $id = Crypt::decrypt($id);
        $user = User::find($id);
        return view('auth.forgetpassword',['user'=>$user]); // Ensure this view exists
        
    }
    
    public function sendResetLinkEmail(Request $request){
       $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'g-recaptcha-response' => 'required'
        ]);
    
        // ✅ Return JSON validation errors
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
    
        // ✅ Captcha check
        if (!$this->verifyCaptcha($request->input('g-recaptcha-response'), $request->ip())) {
            return response()->json([
                'errors' => ['captcha' => ['Captcha verification failed']]
            ], 422);
        }
    
        // ✅ Check user
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json([
                'errors' => ['email' => ['Email not found']]
            ], 422);
        }
    
        // ✅ Generate reset link
        $data = [
            'name' => $user->name,
            'link' => route('password.restpasswordpage', [
                'id' => Crypt::encrypt($user->id)
            ])
        ];
    
        // ✅ Send Mail
        Mail::to($user->email)->send(new ForgetPassword($data));
    
        return response()->json([
            'message' => 'Password reset link sent successfully.'
        ], 200);

    }
    
    public function passwordchange(Request $request){
        $validator = Validator::make($request->all(), [
            // 'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirmation'=> 'required|same:password',
            'g-recaptcha-response' => 'required'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        
        if (!$this->verifyCaptcha($request->input('g-recaptcha-response'), $request->ip())) {
            return response()->json([
                'errors' => ['captcha' => ['Captcha verification failed']]
            ], 422);
        }
    
        // Find user
        $user = User::find($request->fld_id);
    
        if (!$user) {
            return response()->json([
                'errors' => ['email' => ['User not found']]
            ], 422);
        }
    
        // Update password (IMPORTANT: hash it)
        $user->password = Hash::make($request->password);
        $user->save();
    
        return response()->json([
            'message' => 'Password updated successfully'
        ]);
    }
}
