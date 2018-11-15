<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\User; 
use Illuminate\Support\Facades\Auth; 

class AuthController extends Controller
{
    //
    public function login(Request $request) {
        // $http = new Client([
        //     'timeout' => 3.0
        // ]);

        //return Psr7\str($http);

        // $response = $http->post('http://localhost:8000/oauth/token', [
        //     'form_params' => [
        //         'grant_type' => 'password',
        //         'client_id' => '2',
        //         'client_secret' => 'cD0yECIxkv9znsoGZTVNycf33sld7SHDmDvYzYPZ',
        //         'username' => $request->username,
        //         'password' => $request->password
        //     ],
        // ]);

            if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
                $user = Auth::user(); 
                $success['token'] =  $user->createToken('MyApp')-> accessToken; 
                return response()->json(['success' => $success], $this-> successStatus); 
            } else { 
                return response()->json(['error'=>'Unauthorised'], 401); 
            } 
                

        // return json_decode((string) $response->getBody(), true);
        // try {
             
        // } catch (\GuzzleHttp\RequestException $e) {
        //     //return $e;
        //     if ($e->getStatusCode() == 400) {
        //         return response()->json('Invalid Request, Please enter a username or a password.', $e->getStatusCode());
        //     } else if ($e->getStatusCode() == 401) {
        //         return response()->json('Your credentials are incorrect. Please try again.', $e->getStatusCode());
        //     }

        //     return response()->json('Someting went wrong on the server.', $e->getStatusCode());
        // }

    }
}
