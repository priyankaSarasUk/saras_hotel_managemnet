<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get logged-in user
        $user = Auth::user();

        // Fetch basic statistics
        $totalCustomers = Customer::count();
        $totalRooms = Room::count();

        // Check if 'status' column exists before querying
        if (Schema::hasColumn('rooms', 'status')) {
            $availableRooms = Room::where('status', 'available')->count();
        } else {
            $availableRooms = $totalRooms; // Assume all available if no column
        }

        $totalBookings = Booking::count();

        // ✅ Fetch only today's active bookings using check_in / check_out
        $todaysBookings = Booking::with(['customer', 'room'])
            ->whereDate('check_in', '<=', Carbon::today())
            ->whereDate('check_out', '>=', Carbon::today())
            ->get();

        // Pass data + user to the view
        return view('dashboard', compact(
            'user',
            'totalCustomers',
            'totalRooms',
            'availableRooms',
            'totalBookings',
            'todaysBookings'
        ));
    }
}
