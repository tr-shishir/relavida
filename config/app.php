<?php return array (
  'debug' => true,
  'url' => 'http://localhost/',
  'timezone' => 'UTC',
  'locale' => 'de',
  'fallback_locale' => 'de',
  'key' => 'base64:REVuczJGU3FwUzE4ZWlJN1RsclEzUU5iY1hHMUJZRGY=',
  'cipher' => 'AES-256-CBC',
  'log' => 'daily',
  'providers' => 
  array (
    0 => 'MicroweberPackages\\App\\Providers\\AppServiceProvider',
    1 => 'MicroweberPackages\\App\\Providers\\EventServiceProvider',
    2 => 'MicroweberPackages\\App\\Providers\\RouteServiceProvider',
  ),
  'manifest' => storage_path().DIRECTORY_SEPARATOR.'framework',
  'adminTemplateVersion' => '1.29.3',
);