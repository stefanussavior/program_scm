<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Rest extends BaseConfig
{
    public $supportedResponseFormats = [
        'json' => 'application/json',
        'xml'  => 'application/xml',
        'csv'  => 'application/csv',
    ];

    // Add the following lines
    public $allowOrigin      = '*';
    public $allowMethods     = 'GET, POST, PUT, DELETE, OPTIONS';
    public $allowHeaders     = 'Content-Type, Authorization, X-Requested-With';
    public $allowCredentials = true;
    public $maxAge           = 3600;
}
