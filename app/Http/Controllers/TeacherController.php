<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function getAllTeachers()
    {
        $teachers = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'teacher');
        })->select('id', 'name')->get();
        return response()->json(['teachers' => $teachers], 200);
    }
}
