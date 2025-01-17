<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;//

use Illuminate\Support\Facades\Log;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        Log::debug('Empieza login');

        $input = $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6',
        ], [
            'email.exists' => 'The user credentials were incorrect.',
        ]);
        Log::debug('request()->request->ad');
        
        request()->request->add([
            'grant_type' => 'password',
            'client_id' => env('PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSWORD_CLIENT_SECRET'),
            'username' => $input['email'],
            'password' => $input['password'],
        ]);

        Log::debug('antes del route dispath');
        $response = Route::dispatch(Request::create('/oauth/token', 'POST'));

        $data = json_decode($response->getContent(), true);
        
        Log::debug('Data post login:'.$response->getContent());


        if (!$response->isOk()) {
            return response()->json($data, 401);
        }

        return $data;
    }

    public function logout(Request $request)
    {
        $accessToken = $request->user()->token();

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true,
            ]);

        $accessToken->revoke();

        return response()->json([], 201);
    }
}
