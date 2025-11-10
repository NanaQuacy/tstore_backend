<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessRequest;
use App\Models\Business;
use App\Services\BusinessService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    /**
     * Display a listing of businesses for the authenticated user.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $businesses = BusinessService::getUserBusinesses($request->user());

            return response()->json([
                'message' => 'Businesses retrieved successfully',
                'data' => $businesses,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve businesses',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created business.
     */
    public function store(BusinessRequest $request): JsonResponse
    {
        try {
            $business = BusinessService::createBusiness(
                $request->validated(),
                $request->user()
            );

            return response()->json([
                'message' => 'Business created successfully',
                'data' => $business,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create business',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified business.
     */
    public function show(Business $business): JsonResponse
    {
        try {
            $business = BusinessService::getBusiness($business);

            return response()->json([
                'message' => 'Business retrieved successfully',
                'data' => $business,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve business',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified business.
     */
    public function update(BusinessRequest $request, Business $business): JsonResponse
    {
        try {
            // Check if user is the creator or has permission
            if ($business->user_id !== $request->user()->id && !$request->user()->hasRole('owner')) {
                return response()->json([
                    'message' => 'Unauthorized. You can only update businesses you own.',
                ], 403);
            }

            $business = BusinessService::updateBusiness($business, $request->validated());

            return response()->json([
                'message' => 'Business updated successfully',
                'data' => $business,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update business',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified business.
     */
    public function destroy(Request $request, Business $business): JsonResponse
    {
        try {
            // Check if user is the creator or has permission
            if ($business->user_id !== $request->user()->id && !$request->user()->hasRole('owner')) {
                return response()->json([
                    'message' => 'Unauthorized. You can only delete businesses you own.',
                ], 403);
            }

            BusinessService::deleteBusiness($business);

            return response()->json([
                'message' => 'Business deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete business',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Add a user to a business.
     */
    public function addUser(Request $request, Business $business): JsonResponse
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'is_active' => 'nullable|boolean',
            ]);

            // Check if current user has permission (must be owner of the business)
            if ($business->user_id !== $request->user()->id && !$request->user()->hasRole('owner')) {
                return response()->json([
                    'message' => 'Unauthorized. Only business owners can add users.',
                ], 403);
            }

            $user = \App\Models\User::findOrFail($request->user_id);
            $userBusiness = BusinessService::addUserToBusiness(
                $business,
                $user,
                $request->input('is_active', true)
            );

            return response()->json([
                'message' => 'User added to business successfully',
                'data' => $userBusiness->load('user', 'business'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to add user to business',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove a user from a business.
     */
    public function removeUser(Request $request, Business $business): JsonResponse
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);

            // Check if current user has permission (must be owner of the business)
            if ($business->user_id !== $request->user()->id && !$request->user()->hasRole('owner')) {
                return response()->json([
                    'message' => 'Unauthorized. Only business owners can remove users.',
                ], 403);
            }

            $user = \App\Models\User::findOrFail($request->user_id);
            BusinessService::removeUserFromBusiness($business, $user);

            return response()->json([
                'message' => 'User removed from business successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to remove user from business',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

