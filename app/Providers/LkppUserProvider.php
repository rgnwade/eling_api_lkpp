<?php

namespace App\Providers;

use App\Models\UserLkpp;
use App\Models\DetailsLkpp;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class LkppUserProvider implements UserProvider
{
    public function retrieveByToken ($identifier, $token) {
        throw new Exception('Method not implemented.');
    }

    public function updateRememberToken (Authenticatable $user, $token) {
        throw new Exception('Method not implemented.');
    }

    public function retrieveById ($identifier) {
        return DetailsLkpp::find($identifier);
    }

    public function retrieveByCredentials (array $credentials) {
        $xClientId = $credentials['x-client-id'];
        return DetailsLkpp::where('x-client-id', $xClientId)->first();
    }

    public function validateCredentials (Authenticatable $user, array $credentials) {
        $xClientSecret = $credentials['x-client-secret'];
        return DetailsLkpp::where('x-client-secret', $xClientSecret)->first();
    }
}