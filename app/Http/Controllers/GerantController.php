<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class GerantController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $stats = [
            'total_hotels' => Hotel::where('user_id', $user->id)->count(),
            'pending_hotels' => Hotel::where('user_id', $user->id)->where('status', 'pending')->count(),
            'approved_hotels' => Hotel::where('user_id', $user->id)->where('status', 'approved')->count(),
            'rejected_hotels' => Hotel::where('user_id', $user->id)->where('status', 'rejected')->count(),
        ];

        $recentHotels = Hotel::where('user_id', $user->id)->latest()->take(5)->get();

        return view('gerant.index', compact('stats', 'recentHotels'));
    }

    public function index()
    {
        $user = auth()->user();
        $hotels = Hotel::where('user_id', $user->id)->paginate(10);

        return view('gerant.hotels', compact('hotels'));
    }

    public function create()
    {
        return view('gerant.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('hotels', 'public');
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        Hotel::create($validated);

        return redirect()->route('gerant.hotels.index')->with('success', 'Hotel created successfully');
    }

    public function show(Hotel $hotel)
    {
        $this->authorize('view', $hotel);

        return view('gerant.show', compact('hotel'));
    }

    public function edit(Hotel $hotel)
    {
        $this->authorize('update', $hotel);

        return view('gerant.edit', compact('hotel'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $this->authorize('update', $hotel);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($hotel->image) {
                \Storage::disk('public')->delete($hotel->image);
            }
            $validated['image'] = $request->file('image')->store('hotels', 'public');
        }

        $hotel->update($validated);

        return redirect()->route('gerant.hotels.show', $hotel)->with('success', 'Hotel updated successfully');
    }

    public function destroy(Hotel $hotel)
    {
        $this->authorize('delete', $hotel);

        if ($hotel->image) {
            \Storage::disk('public')->delete($hotel->image);
        }

        $hotel->delete();

        return redirect()->route('gerant.hotels.index')->with('success', 'Hotel deleted successfully');
    }
}
