<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthModuleController extends Controller
{

    public function user_toggle_2fa(Request $request)
    {
        // 1. Get the currently authenticated user
        $user = Auth::user();

        // Check if a user is logged in
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.'
            ], 401); // 401 Unauthorized
        }
        
        //
        if (!$user->phone_verified) {
            return response()->json([
                'success' => false,
                'message' => 'Your phone number is not verified.'
            ], 401); // 401 Unauthorized
        }

        // --- Corrected Logic: Toggle the status once ---

        // 2. Toggle the value of the 'two_factor_enabled' column (true becomes false, false becomes true)
        $user->two_factor_enabled = !$user->two_factor_enabled;
        
        // 3. Get the final status after the toggle
        $new2faStatus = $user->two_factor_enabled;
        
        // 4. Save the updated user model to the database
        $user->save();

        // 5. Prepare the success message
        $action = $new2faStatus ? 'enabled' : 'disabled';

        // 6. Return the JSON response, including the new status
        return response()->json([
            'success' => true,
            'message' => "Two-Factor Authentication {$action} successfully.",
            'enabled' => $new2faStatus // Critical for frontend update
        ]);
    }
    
    public function profile_page_view(){
        $user = Auth::user();
        
         return view('user-dashboard.profile',['user'=>$user]);
    }
    public function wallet_page_view(){
        $user = Auth::user();
        
        return view('user-dashboard.wallet',['user'=>$user]);
    }
}
