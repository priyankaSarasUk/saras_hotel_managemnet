<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers with filters.
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        // Show only customers of the logged-in user
        $query->where('user_id', auth()->id());

        // Apply filters
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Fetch customers with latest first
        $customers = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('customers.index', compact('customers'));
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|digits:10',
            'address' => 'nullable|string|max:255',
            'email'   => 'nullable|email|max:255',
        ]);

        // Attach logged-in user_id
        $validated['user_id'] = auth()->id();

        // Create customer
        Customer::create($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer added successfully.');
    }

    /**
     * Show the form for editing a customer.
     */
    public function edit(Customer $customer)
    {
        // Prevent editing others’ customers
        if ($customer->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        // Prevent updating others’ customers
        if ($customer->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate input
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|digits:10',
            'address' => 'nullable|string|max:255',
            'email'   => 'nullable|email|max:255',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(Customer $customer)
    {
        // Prevent deleting others’ customers
        if ($customer->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
