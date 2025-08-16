<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

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
        $recentBookings = Booking::with('customer', 'room')
                                ->latest()
                                ->take(5)
                                ->get();

        // Pass data + user to the view
        return view('dashboard', compact(
            'user',
            'totalCustomers',
            'totalRooms',
            'availableRooms',
            'totalBookings',
            'recentBookings'
        ));
    }
}
