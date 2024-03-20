<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // Validasi input dari request
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'password' => 'required',
            'name' => 'required',
        ]);

        // Jika validasi gagal, kembalikan respon error
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Buat user baru
        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'name' => $request->name,
        ]);

        // Berikan token autentikasi kepada user yang baru terdaftar
        $accessToken = $user->createToken('authToken')->accessToken;

        // Kembalikan respon sukses dengan token autentikasi
        return response()->json(['user' => $user, 'access_token' => $accessToken], 201);
    }

    /**
     * Log in user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Validasi input dari request
        $credentials = $request->only('username', 'password');

        // Jika autentikasi gagal, kembalikan respon error
        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Dapatkan user yang telah berhasil login
        $user = Auth::user();

        // Buat token autentikasi baru untuk user
        $accessToken = $user->createToken('authToken')->accessToken;

        // Kembalikan respon sukses dengan token autentikasi
        return response()->json(['user' => $user, 'access_token' => $accessToken], 200);
    }

    /**
     * Update user information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Dapatkan user yang ingin diupdate
        $user = User::findOrFail($id);

        // Validasi input dari request
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        // Jika validasi gagal, kembalikan respon error
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Update informasi user
        $user->update([
            'name' => $request->name,
        ]);

        // Kembalikan respon sukses
        return response()->json(['message' => 'User updated successfully'], 200);
    }

    /**
     * Get user information.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        // Dapatkan user berdasarkan ID
        $user = User::findOrFail($id);

        // Kembalikan data user dalam respon
        return response()->json(['user' => $user], 200);
    }

    /**
     * Log out user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // Revoke token autentikasi yang digunakan oleh user
        $request->user()->token()->revoke();

        // Kembalikan respon sukses
        return response()->json(['message' => 'User logged out successfully'], 200);
    }
}
