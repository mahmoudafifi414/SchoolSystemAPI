<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Client;
use App\Events\UserCreation;
use App\Role;
use App\Subject;
use App\User;
use App\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getUsersOfSameNetwork($numberPerPage = 10)
    {
        $users = User::with('roles')->orderBy('created_at', 'desc')->paginate($numberPerPage);
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

    public function prepareDataToAddOrEditUser()
    {
        $roles = Role::all();
        $classrooms = Classroom::all();
        $years = Year::all();
        $subjects = Subject::all();
        return response()->json(['roles' => $roles, 'classrooms' => $classrooms, 'years' => $years, 'subjects' => $subjects],
            200);
    }

    public function store(Request $request)
    {
        $userInstance = new User;
        $userInstance->name = $request->name;
        $userInstance->email = $request->email;
        $userInstance->password = bcrypt($request->password);
        $userInstance->phone_number = $request->phoneNumber;
        $userInstance->home_phone_number = $request->homePhoneNumber;
        $userInstance->age = $request->age;
        $userInstance->country = $request->country;
        $userInstance->city = $request->city;
        $userInstance->address = $request->address;
        DB::transaction(function () use ($userInstance, $request) {
            $userInstance->save();
            $userDetailsData = array();
            $userDetailsData['userId'] = $userInstance->id;
            $userDetailsData['roleName'] = $request->roleName;
            $userDetailsData['yearId'] = $request->year;
            $userDetailsData['classroomId'] = $request->classroom;
            $userDetailsData['subjectId'] = $request->subject;
            $userDetailsData['roles'] = $request->roles;
            event(new UserCreation($userDetailsData, $userInstance));
        });
        return response()->json(['data' => $request->name]);
    }

    public function edit($id)
    {
        $userData = User::find($id);
        return response()->json(['preparedData' => $this->prepareDataToAddOrEditUser(), 'userData' => $userData], 200);
    }

    public function update(Request $request, $id)
    {

    }

    public function getUserDetails()
    {
        return response()->json(Auth::user(), 200);
    }
}
