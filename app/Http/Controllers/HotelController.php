<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        $query = Hotel::where('status', 'approved');

        $hoteladdress = Hotel::where('status', 'approved')
            ->select('address')
            ->distinct()
            ->pluck('address');

        if ($request->filled('address')) {
            $query->where('address', $request->input('address'));
        }

        $hotels = $query->paginate(6)->withQueryString();

        return view('hotels.index', compact('hotels', 'hoteladdress'));
    }

    public function create()
    {
        return view('hotels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'address' => 'required|string|max:255',
        ]);

        Hotel::create($validated);

        return redirect()->route('hotels.index');
    }

    public function edit(Hotel $hotel)
    {
        return view('hotels.edit', compact('hotel'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'address' => 'required|string|max:255',
        ]);

        $hotel->update($validated);

        return redirect()->route('hotels.index');
    }

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();

        return redirect()->route('hotels.index');
    }
}
