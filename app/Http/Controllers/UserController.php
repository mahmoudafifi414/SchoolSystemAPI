<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Client;
use App\Role;
use App\User;
use App\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUsersOfSameNetwork($numberPerPage = 10)
    {
        $users = User::with('roles')->paginate($numberPerPage);
        return response()->json(['users' => $users], 200);
    }


    public function create(Request $request)
    {
        $valid = validator($request->only('email', 'name', 'password', 'mobile'), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($valid->fails()) {
            $jsonError = response()->json($valid->errors()->all(), 400);
            return \Response::json($jsonError);
        }
        $data = request()->only('email', 'name', 'password');

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $client = Client::where('password_client', 1)->first();
        $request->request->add([
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $data['email'],
            'password' => $data['password'],
            'scope' => null,
        ]);
        $token = Request::create(
            'oauth/token',
            'POST'
        );
        return \Route::dispatch($token);
    }

    public function login(Request $request)
    {
        $valid = validator($request->only('email', 'name', 'password', 'mobile'), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($valid->fails()) {
            $jsonError = response()->json($valid->errors()->all(), 400);
            return \Response::json($jsonError);
        }
        $data = request()->only('email', 'name', 'password');
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $client = Client::where('password_client', 1)->first();
            $request->request->add([
                'grant_type' => 'password',
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'username' => $data['email'],
                'password' => $data['password'],
                'scope' => null,
            ]);
            $token = Request::create(
                'oauth/token',
                'POST'
            );
            $response = \Route::dispatch($token);
            $responseArrayToModify = json_decode($response->getContent(), true);
            $responseArrayToModify['userData'] = Auth::user();
            $responseArrayToModify['meta'] = array('message' => 'Successfully login', 'auth' => 'yes');
            $response->setContent(json_encode($responseArrayToModify));
            return $response;
        } else {
            return response()->json([
                'meta' => [
                    'error' => 'Unauthorized',
                    'message' => 'Email and Password not matching',
                    'auth' => 'no'
                ]
            ],
                200);
        }
    }

    public function prepareDataToAddNewUser()
    {
        $roles = Role::all();
        $classrooms = Classroom::all();
        $years = Year::all();
        return response()->json(['roles' => $roles, 'classrooms' => $classrooms,'years'=>$years], 200);
    }

    public function getUserDetails()
    {
        return response()->json(Auth::user(), 200);
    }
}
