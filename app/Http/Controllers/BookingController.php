<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    /**
     * Display a listing of bookings, optionally filtered.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['customer', 'room', 'user']);

        // Filters
        if ($request->filled('customer_name')) {
            $query->whereHas('customer', fn($q) => $q->where('name', 'like', '%' . $request->customer_name . '%'));
        }

        if ($request->filled('booking_date')) {
            $query->whereDate('check_in', $request->booking_date);
        }

        if ($request->filled('checkout_date')) {
            $query->whereDate('check_out', $request->checkout_date);
        }

        if ($request->filled('customer_id')) { // filter bookings by a specific customer
            $query->where('customer_id', $request->customer_id);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(10);

        // Pass customer if filtered by customer
        $customer = $request->filled('customer_id') ? Customer::find($request->customer_id) : null;

        return view('bookings.index', compact('bookings', 'customer'));
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
            'customer_id'   => 'required|exists:customers,id',
            'room_id'       => 'required|exists:rooms,id',
            'booking_date'  => 'required|date',
            'checkout_date' => 'required|date|after_or_equal:booking_date',
            'members'       => 'required|integer|min:1',
            'adults'        => 'required|integer|min:1',
            'childs'        => 'required|integer|min:0',
            'amount'        => 'required|numeric|min:0',
            'id_front.*'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'id_back.*'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $idFrontPaths = $request->hasFile('id_front') 
            ? array_map(fn($file) => $file->store('id_uploads/front', 'public'), $request->file('id_front')) 
            : [];

        $idBackPaths = $request->hasFile('id_back') 
            ? array_map(fn($file) => $file->store('id_uploads/back', 'public'), $request->file('id_back')) 
            : [];

        Booking::create([
            'customer_id' => $validated['customer_id'],
            'room_id'     => $validated['room_id'],
            'user_id'     => auth()->id(),
            'check_in'    => $validated['booking_date'],
            'check_out'   => $validated['checkout_date'],
            'members'     => $validated['members'],
            'adults'      => $validated['adults'],
            'childs'      => $validated['childs'],
            'amount'      => $validated['amount'],
            'id_front'    => $idFrontPaths,
            'id_back'     => $idBackPaths,
        ]);

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
            'customer_id'   => 'required|exists:customers,id',
            'room_id'       => 'required|exists:rooms,id',
            'booking_date'  => 'required|date',
            'checkout_date' => 'required|date|after_or_equal:booking_date',
            'members'       => 'required|integer|min:1',
            'adults'        => 'required|integer|min:1',
            'childs'        => 'required|integer|min:0',
            'amount'        => 'required|numeric|min:0',
            'id_front.*'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'id_back.*'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Append new files to existing arrays
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

        $booking->update([
            'customer_id' => $validated['customer_id'],
            'room_id'     => $validated['room_id'],
            'user_id'     => auth()->id(),
            'check_in'    => $validated['booking_date'],
            'check_out'   => $validated['checkout_date'],
            'members'     => $validated['members'],
            'adults'      => $validated['adults'],
            'childs'      => $validated['childs'],
            'amount'      => $validated['amount'],
            'id_front'    => $idFrontPaths,
            'id_back'     => $idBackPaths,
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully!');
    }

    public function deleteFront(Booking $booking, $index)
    {
        $files = $booking->id_front ?? [];
        if (isset($files[$index])) {
            Storage::disk('public')->delete($files[$index]);
            unset($files[$index]);
            $booking->id_front = array_values($files);
            $booking->save();
        }
        return back()->with('success', 'Front ID deleted successfully.');
    }

    public function deleteBack(Booking $booking, $index)
    {
        $files = $booking->id_back ?? [];
        if (isset($files[$index])) {
            Storage::disk('public')->delete($files[$index]);
            unset($files[$index]);
            $booking->id_back = array_values($files);
            $booking->save();
        }
        return back()->with('success', 'Back ID deleted successfully.');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->id_front) {
            foreach ($booking->id_front as $file) {
                Storage::disk('public')->delete($file);
            }
        }
        if ($booking->id_back) {
            foreach ($booking->id_back as $file) {
                Storage::disk('public')->delete($file);
            }
        }

        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully.');
    }

    // Show a single booking
    public function show($id)
    {
        $booking = Booking::with(['customer', 'room', 'user'])->findOrFail($id);
        return view('bookings.show', compact('booking'));
    }

    // Optional: Get bookings for a specific customer
    public function customerBookings($customerId)
    {
        $bookings = Booking::with(['room', 'user'])
            ->where('customer_id', $customerId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $customer = Customer::findOrFail($customerId);

        return view('bookings.index', compact('bookings', 'customer'));
    }
}
