<x-mail::message>
# Welcome {{ $user->name }}!

Your account has been created successfully. Below are your login details:

- Email: `{{ $user->email }}`
- Password: `{{ $tempPassword }}`

Please change your password after first login for security.

<x-mail::button :url="route('login')">
Login to your account
</x-mail::button>

If you have any questions, reply to this email and we’ll help.

Thanks,
<br>
{{ config('app.name') }}
</x-mail::message>
