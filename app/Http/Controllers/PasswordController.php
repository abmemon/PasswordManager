<?php

namespace App\Http\Controllers;

use App\Models\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class PasswordController extends Controller {
    public function __construct() {
        //$this->middleware('auth');
    }

    public function index() {
        $passwords = Auth::user()->passwords;

        return view('passwords.index', compact('passwords'));
    }

    public function store(Request $request) {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255',
        ]);

        $generatedPassword = Str::random(16);
        $encryptedPassword = Crypt::encryptString($generatedPassword);

        Password::create([
            'user_id' => Auth::id(),
            'site_name' => $request->site_name,
            'username' => $request->username,
            'password_encrypted' => $encryptedPassword,
        ]);

        return redirect()->route('passwords.index')->with('success', 'Password stored successfully!');
    }

    public function show($id) {
        $password = Password::where('user_id', Auth::id())->findOrFail($id);
        $decryptedPassword = Crypt::decryptString($password->password_encrypted);
        return view('passwords.show', compact('password', 'decryptedPassword'));
    }

    public function destroy($id) {
        $password = Password::where('user_id', Auth::id())->findOrFail($id);
        $password->delete();
        return redirect()->route('passwords.index')->with('success', 'Password deleted!');
    }
}
