<?php

return [
    'instagram' => env('SALON_INSTAGRAM'),
    'facebook' => env('SALON_FACEBOOK'),
    'tiktok' => env('SALON_TIKTOK'),
    'whatsapp' => env('SALON_WHATSAPP'), // digits only, with country code, e.g. 21612345678
    'email' => env('SALON_EMAIL'),

    // Real reviews only. Example: ['quote' => 'Text of the review', 'name' => 'First name']
    'testimonials' => [],
];