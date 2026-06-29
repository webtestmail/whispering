<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'form_type',
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'guests',
        'checkin',
        'checkout',
        'nights',
        'terms',
        'newsletter',
        'verify_token',
        'verified_at',
        'status',
    ];

    protected $casts = [
        'checkin' => 'date',
        'checkout' => 'date',
        'terms' => 'boolean',
        'newsletter' => 'boolean',
        'verified_at' => 'datetime',
    ];

    public function getFormTypeLabelAttribute(): string
    {
        return match ($this->form_type) {
            'booking' => 'Booking Enquiry',
            'contact' => 'Contact',
            'newsletter' => 'Newsletter',
            default => ucfirst(str_replace('_', ' ', $this->form_type ?? 'contact')),
        };
    }
}
