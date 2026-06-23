<x-mail::message>
# Hello {{ $application->contact_name ?? 'Applicant' }},

We regret to inform you that your application has been rejected.

@if(!empty($application->message))
**Your submitted message:**

{{ $application->message }}

@endif

Please feel free to reach out if you need more information or want to reapply.

<x-mail::button :url="route('contact')">
Contact Support
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
