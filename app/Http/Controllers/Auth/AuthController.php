<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Admin\Company;
use App\Models\Admin\Pages;
use App\Models\Admin\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; 
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Application;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{


    public function clickToVerify(Request $request)
    {
        if (!$request->email || !$request->phone) {
            return response()->json([
                'success' => false, 
                'message' => 'Email and Phone are required.'
            ], 422);
        }

        $exists = User::where('email', $request->email)
                    ->orWhere('phone', $request->phone)
                    ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'This email or phone number is already registered.'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Verification successful! You can now proceed.'
        ]);
    }
    public function edit_profile(){
        $headerData = $this->header();
        $footerData = $this->footer();
        $user = Auth::user();
        return view('user-dashboard.edit-profile', compact('headerData', 'footerData','user'));
    }
    
    
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

    $data = $response->json();

    // 🔥 DEBUG THIS
    \Log::info('CAPTCHA RESPONSE', $data);

    return $data['success'] ?? false;
}


    public function application_submit(Request $request)
    {
        // dd($request->all());
        // 1. Validation
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email|unique:applications,email',
            'phone'             => 'required',
            'company_name'      => 'required|string|max:255',
            'contact_name'      => 'required|string|max:255',
            'country_id'           => 'required',
            'address'           => 'required',
            'organization_type' => 'required',
            'website'           => 'required',
            'category'          => 'required|array|min:1', // Matches name="category[]"
            'g-recaptcha-response' => 'required'
        ], [
            // Custom messages to match your "Terms" error
            'category.required' => 'You must accept the terms and application rules.',
        ]);

        // 2. Check if validation fails
       if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors()       
            ], 422);
        }
        
        if (!$this->verifyCaptcha($request->input('g-recaptcha-response'), $request->ip())) {
        return response()->json([
            'errors' => ['captcha' => ['Captcha verification failed']]
        ], 422);
        }

        try {
            // 3. Logic to save the data
            Application::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Your application has been submitted successfully!'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }
    public function profile_password_update(Request $request){
        $request->validate([
        'current_password' => ['required', 'current_password'], // Built-in Laravel rule
        'new_password' => ['required', 'confirmed', Password::min(8)],
    ]);

    $user = $request->user();
    
    $user->update([
        'password' => Hash::make($request->new_password)
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Password updated successfully!'
    ]);
    }
    
    private function header()
    {
        $company = Company::find(1);
    
        $pages = Pages::select('header_footer_name', 'client_page_urls')
            ->whereIn('visibility', ['both', 'header'])
            ->where('status', 'active')
            ->get();
    
        $services = Services::select('service_name', 'service_url')
            ->whereIn('visibility', ['both', 'header'])
            ->where('status', 'active')
            ->get();
    
        return [
            'company' => $company,
            'pages' => $pages,
            'services' => $services
        ];
    }

    private function footer()
    {
        $company = Company::find(1);
    
        $pages = Pages::select('header_footer_name', 'client_page_urls')
            ->whereIn('visibility', ['both', 'footer'])
            ->where('status', 'active')
            ->get();
    
        $services = Services::select('service_name', 'service_url')
            ->whereIn('visibility', ['both', 'footer'])
            ->where('status', 'active')
            ->get();
    
        return [
            'company' => $company,
            'pages' => $pages,
            'services' => $services
        ];
    }
    public function login_auth(Request $request) {
        // Validate the input
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6',
        ]);
    
        // Fetch user
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }
    
        // Check if user is active (if needed)
        if ($user->is_active != true) {
            return response()->json([
                'success' => false,
                'message' => 'Account not activated'
            ], 403);
        }
    
        // Attempt authentication
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
    
        if (auth()->attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'redirect' => route('my-dashboard')
            ]);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }
        
    
    
    public function profile_update(Request $request) 
    {
        $user = Auth::user();
    
       $validatedData = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName'  => 'required|string|max:255',
            'phone'     => 'required|string|max:14|unique:users,phone,' . $user->id,
            'dob'       => 'nullable|date',
            'about'     => 'nullable|string|max:500',
            'location'  => 'nullable|string|max:255',
            'niche'     => 'nullable|string',
        ], [
            'phone.unique' => 'Phone number already in use.'
        ]);
        
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|min:8|confirmed', 
            ]);
        
            $password = Hash::make($request->password);
        } else {
            // Keep the existing password if the user left the field blank
            $password = $user->password;
        }
        
    
        DB::beginTransaction();
    
        try {
         
            $user->update([
              
                'first' => $validatedData['firstName'], 
                'last'  => $validatedData['lastName'],
                'phone' => $validatedData['phone'],
                'dob'   => $validatedData['dob'],
                'password'=> $password,
                // 'is_active' =>  1,
            ]);
    
            $user->userprofile()->update([
                'about'    => $validatedData['about'],
                'location' => $validatedData['location'],
                'niche'=> $request->niche,
                
            ]);
            
            
    
            DB::commit();
    
        } catch (\Exception $e) {
            DB::rollBack();
            // You can log the error here if needed: Log::error($e->getMessage());
            return back()->with('error', 'Profile update failed due to a server error.');
        }
        
        if ($user->wasChanged('phone')) {
           
            return redirect()->route('otp.verify.route')->with('info', 'Please verify your new phone number.');
        }
    
        return redirect('/my-dashboard')->with('success', 'Profile updated successfully.');
    }



    public function signup_view(){
        $headerData = $this->header();
        $footerData = $this->footer();
        return view('Auth.signup', compact('headerData', 'footerData'));
    }
    public function login_view(){
        

        $headerData = $this->header();
        $footerData = $this->footer();
        return view('auth.login', compact('headerData', 'footerData'));
    }
    public function complete_profile(){
        $headerData = $this->header();
        $footerData = $this->footer();
        $user = Auth::user();
        // if($user->is_active == 1){
        //     return redirect('/my-dashboard');
        // }
        return view('user-dashboard.settings', compact('headerData', 'footerData'));
    }
    public function my_dashboard(){
        $headerData = $this->header();
        $footerData = $this->footer();
        $authUser = Auth::user();

        if (! $authUser->canAccessMemberDashboard()) {
            abort(403, 'You do not have permission to access the member dashboard.');
        }

        return view('user-dashboard.dashboard', compact('headerData', 'footerData'));
    }
    public function logout(Request $request)
    {
        // 1. Log the user out
        Auth::logout();

        // 2. Invalidate the session (security measure)
        $request->session()->invalidate();

        // 3. Regenerate the session's CSRF token (security measure)
        $request->session()->regenerateToken();

        // 4. Redirect the user to the login page (or home)
        return redirect('/')->with('status', 'You have been successfully logged out.');
    }


        public function clickToVerifyforcontact(Request $request)
            {
                if (!$request->email) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Email is required.'
                    ], 422);
                }
         
                $exists = User::where('email', $request->email)
                            ->exists();
         
                if ($exists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'This email or phone number is already registered.'
                    ]);
                }
                return response()->json([
                    'success' => true,
                    'message' => 'Verification successful! You can now proceed.'
                ]);
            }
 
}
