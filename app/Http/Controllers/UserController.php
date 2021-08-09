<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request, User $user)
    {
        $id = isset($request->user()->id) ? $request->user()->id : Auth::id();
        if (isset($id)) {
            $status = $user->find($id)->first()->status;
            if ($status === 'admin') {
                return $user;
            } else {
                return $user->find($id);
            }
        }
    }
}
