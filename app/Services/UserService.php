<?php

namespace App\Services;

use App\Events\UserRegistered;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public static function getAllUsers(){
        return User::all();
    }
    public static function createUser($data){
        $user = User::create($data);
        if (!$user) {
            return response()->json(['error' => 'Failed to create user'], 500);
        }
        return $user;
    }
    public static function updateUser($id, $data){
        $user = User::find($id);
        $user->update($data);
        return $user;
    }
    public static function deleteUser($id){
        $user = User::find($id);
        $user->delete();
        return $user;
    }

    /**
     * Register a new user
     */
    public static function register(array $data)
    {
        // Hash the password
        $data['password'] = Hash::make($data['password']);
        
        // Set default values
        $data['is_active'] = $data['is_active'] ?? true;
        
        // Create the user
        $user = User::create($data);
        
        // Create a token for the user
        $token = $user->createToken('auth-token')->plainTextToken;
        
        // Dispatch event to send welcome email
        event(new UserRegistered($user));
        
        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * Login user and return token
     */
    public static function login(array $credentials)
    {
        // Find user by email
        $user = User::where('email', $credentials['email'])->first();
        
        // Check if user exists and password is correct
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return null;
        }
        
        // Check if user is active
        if (!$user->is_active) {
            return false; // User is inactive
        }
        
        // Create a token for the user
        $token = $user->createToken('auth-token')->plainTextToken;
        
        return [
            'user' => $user,
            'token' => $token,
        ];
    }
}
