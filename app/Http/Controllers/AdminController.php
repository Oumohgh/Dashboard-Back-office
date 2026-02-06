<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $hotels = Hotel::where('status', 'pending')
            ->with('user')
            ->get();

        return view('admin.admin', compact('hotels'));
    }

    public function approve(Hotel $hotel)
    {
        $hotel->update(['status' => 'approved']);

        return redirect()->route('admin.index');
    }

    public function reject(Hotel $hotel)
    {
        $hotel->update(['status' => 'rejected']);

        return redirect()->route('admin.index');
    }
}
