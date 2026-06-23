<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models*\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\UserProfile;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
        public function rules()
    {
        $userType = $this->input('user_type');

        // Base rules applicable to both Influencer and Brand
        $rules = [
            '+' => ['required', Rule::in(['influencer', 'brand'])],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // Check if email is unique in the 'users' table
                'unique:users,email',
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required', 'accepted'],
        ];

        // Conditional rules for Influencer
        if ($userType === 0) {
            $rules = array_merge($rules, [
                'username' => [
                    'nullable',
                    'string',
                    'max:255',
                    // Unique username check
                    'unique:users,username',
                    'regex:/^[a-zA-Z0-9_]+$/', // Optional: enforce alphanumeric/underscore
                ],
                'follower_count' => ['nullable', 'integer', 'min:0'],
                'instagram_url' => ['nullable', 'url', 'max:255'],
                'youtube_url' => ['nullable', 'url', 'max:255'],
                'tiktok_url' => ['nullable', 'url', 'max:255'],
                'niche' => ['required', 'string', 'max:255'],
                'bio' => ['nullable', 'string', 'max:1000'],
                // Profile Picture Validation: image, max 2048KB (2MB)
                'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            ]);
        }

        // Conditional rules for Brand
        if ($userType === 2) {
            $rules = array_merge($rules, [
                'company_name' => ['required', 'string', 'max:255'],
                'website' => ['nullable', 'url', 'max:255'],
                'industry' => ['required', 'string', 'max:255'],
                'budget' => ['required', 'string', 'max:255'],
                'campaign_goal' => ['nullable', 'string', 'max:1000'],
                // Company Logo Validation: image, max 2048KB (2MB)
                'company_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            ]);
        }

        return $rules;
    }
    
        public function messages()
    {
        return [
            'email.unique' => 'The email address you entered is already registered. If you previously signed up with Google, please use the Google login option.',
            'username.unique' => 'This username is already taken. Please choose a different one.',
            'profile_picture.max' => 'The profile picture must not exceed 2 megabytes.',
            'company_logo.max' => 'The company logo must not exceed 2 megabytes.',
        ];
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
