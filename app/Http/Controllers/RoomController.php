<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::orderBy('created_at', 'desc')->paginate(10);
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return redirect()->route('rooms.index');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'hotel_name' => 'required|string|max:255',
            'room_number' => 'required|string|max:255',
            'room_name' => 'required|string|max:255',
            'room_type' => ['required', Rule::in(['single', 'double', 'triple', '4 bed'])],
        ]);

        Room::create($validatedData);

        return redirect()->route('rooms.index')->with('success', 'Room added successfully!');
    }
}
