<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\Admin\Company;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function admin_login_view()
    {
        return view('admin.Auth.login');
    }

    public function admin_auth(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

   
        $admin = \App\Models\Admin\Admin::where('email', $request->email)->first();

        if (!$admin) {
            session()->flash('error','Email not found');
            return redirect()->back()->with(['error' => 'Admin not found'])->withInput();
        }
        

        // Check account status
        if (!$admin->is_active || $admin->is_active == 0) {
            return redirect()->back()->with(['error' => 'Your account is inactive'])->withInput();
        }
        
        

        // Login using admin guard
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();
            Session::put('user_name', $admin->first_name . " " . $admin->last_name);
            Session::put('user_email', $admin->email);
            Session::put('profile_image', $admin->image);

            $company = Company::select('company_icon', 'company_logo', 'company_name')->where('id', 1)->first();
            if ($company) {
                Session::put('company_icon', $company->company_icon);
                Session::put('company_logo', $company->company_logo);
                Session::put('company_name', $company->company_name);
            } else {
                Log::error('Company not found!');
            }

            return redirect()->route('admin.my-dashboard');
        }

        // Failed authentication
        return redirect()->back()->withErrors(['error' => 'Invalid credentials'])->withInput();
    }

   public function my_dashboard()
    {
        $admin = Auth::guard('admin')->user();

        if ($admin->is_active == 0) {
            return redirect('/complete-profile');
        }

        return view('admin.dashboard');
    }

    public function editProfile(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'firstName' => 'required|string',
                'email' => 'required|string',
                'phone' => 'required|integer',
            ], [
                'firstName.required' => 'First Name is required!',
                'firstName.string' => 'First Name should be string format!',
                'email.required' => 'E-Mail is required!',
                'email.email' => 'Invalid E-Mail!',
                'phone.required' => 'Phone is required!',
                'phone.integer' => 'Phone should be integer type!',
            ]);

            $id = Auth::guard('admin')->id();
            $profile = Admin::findOrFail($id);
            $profile->first_name = $request->firstName;
            $profile->last_name = $request->lastName;
            $profile->email = $request->email;
            $profile->phone = $request->phone;

            if (!empty($request->file('profile_image'))) {
                $path = 'images/admin/';
                $filePath = $this->storeImage($request->file("profile_image"), $path, $profile->profile_image);
                $profile->image = $filePath;
            }

            if ($profile->save()) {
                $request->session()->flash('success', 'Profile is updated Successfully!');
                return redirect()->route('admin.edit.profile');
            } else {
                $request->session()->flash('error', 'Updation Error!');
                return redirect()->route('admin.edit.profile');
            }
        } else {
            $profile = Auth::guard('admin')->user();
            return view('admin.profile-ops', ["profile" => $profile]);
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.panel');
    }
}
