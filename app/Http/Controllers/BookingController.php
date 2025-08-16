<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Room;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['customer', 'room']);

        // Filters
        if ($request->filled('customer_name')) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->customer_name.'%');
            });
        }

        if ($request->filled('booking_date')) {
            // DB column is check_in, not booking_date
            $query->whereDate('check_in', $request->booking_date);
        }

        if ($request->filled('checkout_date')) {
            $query->whereDate('check_out', $request->checkout_date);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $customers = Customer::all();
        $rooms = Room::all();
        return view('bookings.create', compact('customers', 'rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'room_id' => 'required|exists:rooms,id',
            'booking_date' => 'required|date',
            'checkout_date' => 'required|date|after_or_equal:booking_date',
            'members' => 'required|integer|min:1',
            'adults' => 'required|integer|min:1',
            'childs' => 'required|integer|min:0',
            'amount' => 'required|numeric|min:0',
            'id_front.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'id_back.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Handle front ID uploads
        $idFrontPaths = [];
        if ($request->hasFile('id_front')) {
            foreach ($request->file('id_front') as $file) {
                $idFrontPaths[] = $file->store('id_uploads/front', 'public');
            }
        }

        // Handle back ID uploads
        $idBackPaths = [];
        if ($request->hasFile('id_back')) {
            foreach ($request->file('id_back') as $file) {
                $idBackPaths[] = $file->store('id_uploads/back', 'public');
            }
        }

        $bookingData = [
            'customer_id' => $validated['customer_id'],
            'room_id' => $validated['room_id'],
            'check_in' => $validated['booking_date'],     // map booking_date → check_in
            'check_out' => $validated['checkout_date'],   // map checkout_date → check_out
            'members' => $validated['members'],
            'adults' => $validated['adults'],
            'childs' => $validated['childs'],
            'amount' => $validated['amount'],
            'id_front' => $idFrontPaths,
            'id_back' => $idBackPaths,
        ];

        Booking::create($bookingData);

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully!');
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $customers = Customer::all();
        $rooms = Room::all();

        return view('bookings.edit', compact('booking', 'customers', 'rooms'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'room_id' => 'required|exists:rooms,id',
            'booking_date' => 'required|date',
            'checkout_date' => 'required|date|after_or_equal:booking_date',
            'members' => 'required|integer|min:1',
            'adults' => 'required|integer|min:1',
            'childs' => 'required|integer|min:0',
            'amount' => 'required|numeric|min:0',
            'id_front.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'id_back.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Existing file paths, if any
        $idFrontPaths = $booking->id_front ?? [];
        if ($request->hasFile('id_front')) {
            foreach ($request->file('id_front') as $file) {
                $idFrontPaths[] = $file->store('id_uploads/front', 'public');
            }
        }

        $idBackPaths = $booking->id_back ?? [];
        if ($request->hasFile('id_back')) {
            foreach ($request->file('id_back') as $file) {
                $idBackPaths[] = $file->store('id_uploads/back', 'public');
            }
        }

        $bookingData = [
            'customer_id' => $validated['customer_id'],
            'room_id' => $validated['room_id'],
            'check_in' => $validated['booking_date'],
            'check_out' => $validated['checkout_date'],
            'members' => $validated['members'],
            'adults' => $validated['adults'],
            'childs' => $validated['childs'],
            'amount' => $validated['amount'],
            'id_front' => $idFrontPaths,
            'id_back' => $idBackPaths,
        ];

        $booking->update($bookingData);

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully!');
    }
}
