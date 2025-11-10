<?php

namespace App\Services;

use App\Models\Business;
use App\Models\User;
use App\Models\UserBusiness;
use Illuminate\Support\Str;

class BusinessService
{
    /**
     * Generate a unique 6-character business code.
     */
    public static function generateBusinessCode(): string
    {
        do {
            // Generate a random 6-character alphanumeric code (uppercase)
            $code = strtoupper(Str::random(6));
        } while (Business::where('business_code', $code)->exists());

        return $code;
    }

    /**
     * Create a new business and assign owner role.
     */
    public static function createBusiness(array $data, User $user): Business
    {
        // Generate unique business code
        $data['business_code'] = self::generateBusinessCode();
        $data['user_id'] = $user->id;
        $data['is_active'] = $data['is_active'] ?? true;

        // Create the business
        $business = Business::create($data);

        // Add user to user_businesses table
        UserBusiness::create([
            'user_id' => $user->id,
            'business_id' => $business->id,
            'is_active' => true,
        ]);

        // Assign "owner" role to the creator
        if (!$user->hasRole('owner')) {
            $user->assignRole('owner');
        }

        // Dispatch event to send business owner welcome email
        \App\Events\BusinessCreated::dispatch($user, $business);

        return $business->load('creator', 'users');
    }

    /**
     * Update a business.
     */
    public static function updateBusiness(Business $business, array $data): Business
    {
        $business->update($data);
        return $business->load('creator', 'users');
    }

    /**
     * Get all businesses for a user.
     */
    public static function getUserBusinesses(User $user)
    {
        return $user->businesses()->with('creator')->get();
    }

    /**
     * Get a specific business.
     */
    public static function getBusiness(Business $business): Business
    {
        return $business->load('creator', 'users');
    }

    /**
     * Delete a business (soft delete).
     */
    public static function deleteBusiness(Business $business): bool
    {
        return $business->delete();
    }

    /**
     * Add a user to a business.
     */
    public static function addUserToBusiness(Business $business, User $user, bool $isActive = true): UserBusiness
    {
        // Check if user is already associated with the business
        $userBusiness = UserBusiness::where('user_id', $user->id)
            ->where('business_id', $business->id)
            ->first();

        if ($userBusiness) {
            // Update if exists
            $userBusiness->update(['is_active' => $isActive]);
            return $userBusiness;
        }

        // Create new association
        return UserBusiness::create([
            'user_id' => $user->id,
            'business_id' => $business->id,
            'is_active' => $isActive,
        ]);
    }

    /**
     * Remove a user from a business.
     */
    public static function removeUserFromBusiness(Business $business, User $user): bool
    {
        return UserBusiness::where('user_id', $user->id)
            ->where('business_id', $business->id)
            ->delete();
    }

    /**
     * Register a user and create their first business as owner.
     */
    public static function registerUserWithBusiness(array $userData, array $businessData): array
    {
        // Hash the password
        $userData['password'] = \Illuminate\Support\Facades\Hash::make($userData['password']);
        $userData['is_active'] = $userData['is_active'] ?? true;

        // Create the user
        $user = User::create($userData);

        // Prepare business data
        $businessData['name'] = $businessData['business_name'] ?? $businessData['name'];
        $businessData['description'] = $businessData['business_description'] ?? $businessData['description'] ?? null;
        $businessData['address'] = $businessData['business_address'] ?? $businessData['address'] ?? null;
        $businessData['phone'] = $businessData['business_phone'] ?? $businessData['phone'] ?? null;
        $businessData['email'] = $businessData['business_email'] ?? $businessData['email'] ?? null;
        $businessData['website'] = $businessData['business_website'] ?? $businessData['website'] ?? null;

        // Create the business
        $business = self::createBusiness($businessData, $user);

        // Create a token for the user
        $token = $user->createToken('auth-token')->plainTextToken;

        // Dispatch event to send welcome email
        \App\Events\UserRegistered::dispatch($user);

        return [
            'user' => $user->load('roles'),
            'business' => $business,
            'token' => $token,
        ];
    }
}

