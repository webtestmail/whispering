<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Public site locales
    |--------------------------------------------------------------------------
    |
    | Used by the locale switcher, session/cookie handling, and SetLocale
    | middleware. Keep this list in sync with files under lang/{locale}/.
    |
    */

    'supported' => ['en', 'es', 'de', 'it', 'pt', 'fr'],

    'switcher' => [
        ['locale' => 'en', 'label' => 'English', 'flag' => 'gb'],
        ['locale' => 'es', 'label' => 'Español', 'flag' => 'es'],
        ['locale' => 'de', 'label' => 'Deutsch', 'flag' => 'de'],
        ['locale' => 'it', 'label' => 'Italiano', 'flag' => 'it'],
        ['locale' => 'pt', 'label' => 'Português', 'flag' => 'pt'],
        ['locale' => 'fr', 'label' => 'Français', 'flag' => 'fr'],
    ],

    /*
    | Source language for the Google Website Translator (must match pageLanguage).
    | Machine translation reads the googtrans cookie, e.g. /en/es — not the hidden combo box.
    */
    'google_translate_source' => env('GOOGLE_TRANSLATE_SOURCE', 'en'),
];
