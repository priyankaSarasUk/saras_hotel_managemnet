<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // Show all rooms
    public function index(Request $request)
    {
        $query = Room::query();

        if ($request->filled('hotel_name')) {
            $query->where('hotel_name', 'like', '%' . $request->hotel_name . '%');
        }

        if ($request->filled('room_number')) {
            $query->where('room_number', 'like', '%' . $request->room_number . '%');
        }

        if ($request->filled('room_type')) {
            $query->where('room_type', 'like', '%' . $request->room_type . '%');
        }

        $rooms = $query->orderBy('created_at', 'desc')->paginate(10);
        $rooms->appends($request->all());

        return view('rooms.index', compact('rooms'));
    }

    // Show create form
    public function create()
    {
        return view('rooms.create');
    }

    // Store new room
    public function store(Request $request)
    {
        $request->validate([
            'hotel_name'   => 'required|string|max:255',
            'room_number'  => 'required|string|max:255|unique:rooms',
            'room_name'    => 'required|string|max:255',
            'room_type'    => 'required|string|max:255',
        ]);

        Room::create($request->all());

        return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
    }

    // Show edit form
    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    // Update room
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'hotel_name'   => 'required|string|max:255',
            'room_number'  => 'required|string|max:255|unique:rooms,room_number,' . $room->id,
            'room_name'    => 'required|string|max:255',
            'room_type'    => 'required|string|max:255',
        ]);

        $room->update($request->all());

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    // Delete room
    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }
}
