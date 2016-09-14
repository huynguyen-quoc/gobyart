<?php
/**
 * Created by PhpStorm.
 * User: huynguyen
 * Date: 9/10/16
 * Time: 10:04 AM
 */
return [
    'full_size'   => storage_path('upload').'/'.env('UPLOAD_FULL_SIZE', 'full/'),
    'medium_size'   => storage_path('upload').'/'.env('UPLOAD_MEDIUM_SIZE', 'medium/'),
    'low_size'   => storage_path('upload').'/'.env('UPLOAD_LOW_SIZE', 'low/'),
    'base64'   => storage_path('upload').'/'.env('UPLOAD_BASE_64', 'base64/')
];
