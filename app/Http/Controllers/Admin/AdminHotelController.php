<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class AdminHotelController extends Controller
{
    /**
     * Constructor - Ensure only admins can access this controller
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->check() && auth()->user()->role === 'admin') {
                return $next($request);
            }

            throw new AuthorizationException('Only admins can access this resource.');
        });
    }

    /**
     * Get all pending hotels for admin review
     *
     * @return JsonResponse
     */
    public function getPendingHotels(): JsonResponse
    {
        try {
            $pendingHotels = Hotel::where('status', 'pending')
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Pending hotels retrieved successfully',
                'data' => $pendingHotels,
                'count' => $pendingHotels->count(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve pending hotels',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get hotel details by ID (admin can only view, not edit)
     *
     * @param int $hotelId
     * @return JsonResponse
     */
    public function showHotel(int $hotelId): JsonResponse
    {
        try {
            $hotel = Hotel::with('user')->findOrFail($hotelId);

            return response()->json([
                'success' => true,
                'message' => 'Hotel details retrieved successfully',
                'data' => $hotel,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Hotel not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Approve a pending hotel
     * Changes hotel status from 'pending' to 'approved'
     * Hotel becomes visible to clients
     *
     * @param int $hotelId
     * @return JsonResponse
     */
    public function approveHotel(int $hotelId): JsonResponse
    {
        try {
            $hotel = Hotel::findOrFail($hotelId);

            // Validate hotel is pending
            if ($hotel->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending hotels can be approved',
                    'current_status' => $hotel->status,
                ], 400);
            }

            // Update hotel status
            $hotel->update(['status' => 'approved']);

            // Log the action (optional - implement if you have a logs table)
            // ActivityLog::create([
            //     'admin_id' => auth()->id(),
            //     'hotel_id' => $hotel->id,
            //     'action' => 'approved',
            //     'timestamp' => now(),
            // ]);

            return response()->json([
                'success' => true,
                'message' => 'Hotel approved successfully',
                'data' => $hotel,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve hotel',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Reject a pending hotel
     * Changes hotel status from 'pending' to 'rejected'
     * Hotel is blocked everywhere (not visible to clients)
     *
     * @param int $hotelId
     * @param string|null $rejectionReason
     * @return JsonResponse
     */
    public function rejectHotel(int $hotelId, ?string $rejectionReason = null): JsonResponse
    {
        try {
            $hotel = Hotel::findOrFail($hotelId);

            // Validate hotel is pending
            if ($hotel->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending hotels can be rejected',
                    'current_status' => $hotel->status,
                ], 400);
            }

            // Update hotel status with rejection reason (if your schema supports it)
            $updateData = ['status' => 'rejected'];
            if ($rejectionReason) {
                $updateData['rejection_reason'] = $rejectionReason;
            }

            $hotel->update($updateData);

            // Log the action (optional)
            // ActivityLog::create([
            //     'admin_id' => auth()->id(),
            //     'hotel_id' => $hotel->id,
            //     'action' => 'rejected',
            //     'reason' => $rejectionReason,
            //     'timestamp' => now(),
            // ]);

            return response()->json([
                'success' => true,
                'message' => 'Hotel rejected successfully',
                'data' => $hotel,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject hotel',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get statistics for admin dashboard
     *
     * @return JsonResponse
     */
    public function getStatistics(): JsonResponse
    {
        try {
            $stats = [
                'total_hotels' => Hotel::count(),
                'pending_count' => Hotel::where('status', 'pending')->count(),
                'approved_count' => Hotel::where('status', 'approved')->count(),
                'rejected_count' => Hotel::where('status', 'rejected')->count(),
            ];

            return response()->json([
                'success' => true,
                'message' => 'Statistics retrieved successfully',
                'data' => $stats,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve statistics',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
