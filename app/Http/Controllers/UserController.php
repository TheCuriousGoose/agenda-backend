<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Users retrieved successfully',
            'users' => User::all()
        ]);
    }
}
