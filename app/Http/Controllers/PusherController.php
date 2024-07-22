<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class PusherController extends Controller
{
    public function authenticate(Request $request)
    {
        $socketId = $request->input('socket_id');
        $channelName = 'one-message';
        $userId = $request->input('user_id');

        // Check if the user is authenticated
        if ($userId) {
            $user = User::find($userId);
            // You might want to perform additional user validation here

            // Generate the authentication data
            $authData = [
                'user_id' => $userId,
                'user_info' => [
                    'name' => $user->name,                     
                ],
            ];

            // Generate the signature for Pusher authentication
            $authData['auth'] = $this->generatePusherSignature($channelName, $socketId, $authData);

            return response()->json($authData);
        }

        // If the user is not authenticated, return a 403 Forbidden response
        return response('Forbidden', 403);
    }

    private function generatePusherSignature($channel, $socketId, $authData)
    {
        $key = config('broadcasting.connections.pusher.key');
        $secret = config('broadcasting.connections.pusher.secret');

        $stringToSign = "{$socketId}:{$channel}";
        $signature = hash_hmac('sha256', $stringToSign, $secret, false);

        return "{$key}:{$signature}";
    }

}

