<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Room;

class RoomController extends Controller
{
    /**
     * Display a listing of the rooms.
     */
    public function index()
    {
        $rooms = Room::orderBy('created_at', 'desc')->paginate(10);
        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new room.
     */
    public function create()
    {
        return view('rooms.create');
    }

    /**
     * Store a newly created room in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'hotel_name'   => 'required|string|max:255',
            'room_number'  => 'required|string|max:255|unique:rooms,room_number',
            'room_name'    => 'required|string|max:255',
            'room_type'    => ['required', Rule::in(['single', 'double', 'triple', '4 bed'])],
        ]);

        Room::create($validatedData);

        return redirect()->route('rooms.index')->with('success', 'Room added successfully!');
    }

    /**
     * Display the specified room.
     */
    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified room.
     */
    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    /**
     * Update the specified room in storage.
     */
    public function update(Request $request, Room $room)
    {
        $validatedData = $request->validate([
            'hotel_name'   => 'required|string|max:255',
            'room_number'  => [
                'required',
                'string',
                'max:255',
                Rule::unique('rooms', 'room_number')->ignore($room->id),
            ],
            'room_name'    => 'required|string|max:255',
            'room_type'    => ['required', Rule::in(['single', 'double', 'triple', '4 bed'])],
        ]);

        $room->update($validatedData);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully!');
    }

    /**
     * Remove the specified room from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully!');
    }
}
