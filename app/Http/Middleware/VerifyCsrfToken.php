<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'api/*',
//        'api/register',
//        'api/login',
//        'api/logout',
//        'api/contacts',
//        'api/contacts/{id}',
    ];
}
