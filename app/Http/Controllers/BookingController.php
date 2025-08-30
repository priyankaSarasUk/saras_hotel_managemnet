<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['customer', 'room', 'user']);

        if ($request->filled('customer_name')) {
            $query->whereHas('customer', fn($q) => $q->where('name', 'like', '%' . $request->customer_name . '%'));
        }

        if ($request->filled('booking_date')) {
            $query->whereDate('booking_date', $request->booking_date);
        }

        if ($request->filled('check_out')) {
            $query->whereDate('check_out', $request->check_out);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(10);
        $customer = $request->filled('customer_id') ? Customer::find($request->customer_id) : null;

        $customers = Customer::all();
        $rooms = Room::all();

        return view('bookings.index', compact('bookings', 'customer', 'customers', 'rooms'));
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
            'customer_id'    => 'required|exists:customers,id',
            'room_id'        => 'required|exists:rooms,id',
            'male'           => 'required|integer|min:0',
            'female'         => 'required|integer|min:0',
            'childs'         => 'required|integer|min:0',
            'relation'       => 'nullable|string|max:255',
            'purpose'        => 'nullable|string|max:255',
            'arrival_from'   => 'nullable|string|max:255',
            'vehicle_number' => 'nullable|string|max:255',
            'amount'         => 'required|numeric|min:0',
            'booking_date'   => 'nullable|date',
            'check_in'       => 'nullable|date',
            'check_out'      => 'nullable|date',
            'id_front.*'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'id_back.*'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $validated['check_in'] = $validated['check_in'] ?? now();
        $validated['check_out'] = $validated['check_out'] ?? now()->addDay()->setTime(11, 0);
        $validated['booking_date'] = $validated['booking_date'] ?? now();

        $validated['members'] = $validated['male'] + $validated['female'] + $validated['childs'];
        $validated['adults'] = $validated['male'] + $validated['female'];
        $validated['user_id'] = auth()->id();

        $validated['id_front'] = $request->hasFile('id_front')
            ? array_map(fn($file) => $file->store('id_uploads/front', 'public'), $request->file('id_front'))
            : [];
        $validated['id_back'] = $request->hasFile('id_back')
            ? array_map(fn($file) => $file->store('id_uploads/back', 'public'), $request->file('id_back'))
            : [];

        Booking::create($validated);

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
            'customer_id'    => 'required|exists:customers,id',
            'room_id'        => 'required|exists:rooms,id',
            'male'           => 'required|integer|min:0',
            'female'         => 'required|integer|min:0',
            'childs'         => 'required|integer|min:0',
            'relation'       => 'nullable|string|max:255',
            'purpose'        => 'nullable|string|max:255',
            'arrival_from'   => 'nullable|string|max:255',
            'vehicle_number' => 'nullable|string|max:255',
            'amount'         => 'required|numeric|min:0',
            'booking_date'   => 'nullable|date',
            'check_in'       => 'nullable|date',
            'check_out'      => 'nullable|date',
            'id_front.*'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'id_back.*'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $validated['check_in'] = $validated['check_in'] ?? $booking->check_in ?? now();
        $validated['check_out'] = $validated['check_out'] ?? $booking->check_out ?? now()->addDay()->setTime(11, 0);
        $validated['booking_date'] = $validated['booking_date'] ?? $booking->booking_date ?? now();

        $validated['members'] = $validated['male'] + $validated['female'] + $validated['childs'];
        $validated['adults'] = $validated['male'] + $validated['female'];
        $validated['user_id'] = auth()->id();

        // Merge existing files with new uploads
        $validated['id_front'] = $booking->id_front ?? [];
        if ($request->hasFile('id_front')) {
            foreach ($request->file('id_front') as $file) {
                $validated['id_front'][] = $file->store('id_uploads/front', 'public');
            }
        }

        $validated['id_back'] = $booking->id_back ?? [];
        if ($request->hasFile('id_back')) {
            foreach ($request->file('id_back') as $file) {
                $validated['id_back'][] = $file->store('id_uploads/back', 'public');
            }
        }

        $booking->update($validated);

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

    public function show($id)
    {
        $booking = Booking::with(['customer', 'room', 'user'])->findOrFail($id);
        return view('bookings.show', compact('booking'));
    }

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
