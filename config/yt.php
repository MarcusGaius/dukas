<?php

return [
    "cred_path" => PATH . 'storage/google_keys.json',
    "scopes" => [
        'https://www.googleapis.com/auth/yt-analytics-monetary.readonly',
        'https://www.googleapis.com/auth/spreadsheets.readonly',
        'https://www.googleapis.com/auth/spreadsheets',
        'https://www.googleapis.com/auth/drive.readonly',
        'https://www.googleapis.com/auth/youtube.readonly',
    ],
    'access_type' => 'offline',
    'spreadsheet' => [
        'key' => '',
        'current_row' => '1',
    ]
];