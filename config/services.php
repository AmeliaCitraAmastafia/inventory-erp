<?php

return [
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI', env('APP_URL').'/auth/google/callback'),
    ],
    'google_drive' => [
        'credentials' => env('GOOGLE_DRIVE_CREDENTIALS'),
        'folder_id' => env('GOOGLE_DRIVE_FOLDER_ID'),
        'client_email' => env('GOOGLE_DRIVE_CLIENT_EMAIL'),
        'private_key' => env('GOOGLE_DRIVE_PRIVATE_KEY'),
    ],
];
