<?php

namespace App\Services;

use Google\Client;

class FirebaseService
{
    public static function getAccessToken()
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/firebase/firebase_credentials.json'));
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $token = $client->fetchAccessTokenWithAssertion();
        return $token['access_token'];
    }
}
