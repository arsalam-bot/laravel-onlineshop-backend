<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //
    public function index(Request $request)
    {
        // get users with pagination
        $users = DB::table('users')->when($request->search, function ($query) use ($request) {
            return $query->where('name', 'like', '%' . $request->search . '%');
        })->paginate(5);
        return view('pages.user.index', compact('users'));
    }

    public function creat()
    {
        return view('pages.dashboard');
    }

    public function store(Request $request)
    {
        return view('pages.dashboard');
    }

    public function show($id)
    {
        return view('pages.dashboard');
    }

    public function edit($id)
    {
        return view('pages.dashboard');
    }

    public function update(Request $request, $id)
    {
        return view('pages.dashboard');
    }

    public function destroy($id)
    {
        return view('pages.dashboard');
    }
}
