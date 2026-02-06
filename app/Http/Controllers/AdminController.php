<?php

namespace App\Http\Controllers;

use App\Models\Hotel;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function hotels()
    {
        $hotels = Hotel::where('status', 'pending')
            ->with('user')
            ->get();

        return view('admin.hotels', compact('hotels'));
    }

    public function approve(Hotel $hotel)
    {
        $hotel->update(['status' => 'approved']);

        return redirect()->route('admin.hotels');
    }

    public function reject(Hotel $hotel)
    {
        $hotel->update(['status' => 'rejected']);

        return redirect()->route('admin.hotels');
    }
}
