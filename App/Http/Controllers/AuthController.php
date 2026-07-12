<?php

namespace App\Http\Controllers;

use App\Core\Request;
use App\Core\Session;
use App\Database\QueryBuilder;

class AuthController
{

    private $tableName = 'users';

    public function loginView()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $data = $request->only(['email', 'password']);

        if (empty($data['email']) || empty($data['password'])) {
            Session::flash('error', 'Email and Password are required.');
            return redirect('/login');
        }

        $user = QueryBuilder::fetchOneRecord($this->tableName, ['email' => $data['email']]);

        if (!$user) {
            Session::flash('error', 'No account found with this email.');
            return redirect('/login');
        }

        if (!password_verify($data['password'], $user->password)) {
            Session::flash('error', 'Incorrect password or email.');
            return redirect('/login');
        }

        Session::put('user_id', $user->id);
        Session::put('user_name', $user->name);
        Session::flash('success', 'Welcome back, ' . $user->name . '!');

        return redirect('/admin');
    }

    public function registerView()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $data = $request->only(['first_name', 'last_name', 'email', 'password']);
        $existingUser = QueryBuilder::fetchOneRecord($this->tableName, ['email' => $data['email']]);

        if ($existingUser) {
            Session::flash('error', 'An account with this email already exists.');
            return redirect('/register');
        }

        $name = $data['first_name'] . ' ' . $data['last_name'];
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        $data = [
            'name' => $name,
            'email'      => $data['email'],
            'password'   => $hashedPassword,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $userId = QueryBuilder::insertRecords($this->tableName, $data);

        if (is_int($userId)) {
            Session::flash('success', 'User Registered Successfully!. Please login!');
            return redirect('/login');
        }

        Session::flash('error', 'Something went wrong!.');
        return redirect('/register');
    }
}
