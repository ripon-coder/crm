<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('front.form');
    }

    public function home()
    {
        return view('front.home');
    }

    public function searchCustomer(Request $request)
    {
        $searchValue = $request->input('search_value');
        
        // Automatically detect if it's an email or phone
        // If it contains '@', treat it as email, otherwise as phone
        if (strpos($searchValue, '@') !== false) {
            // Search by email
            $customer = Customer::where('email', $searchValue)->first();
            return view('front.form', [
                'customer' => $customer,
                'email' => $searchValue,
                'dollarRate' => $customer?->dollar_rate ?? 130
            ]);
        } else {
            // Search by phone
            $customer = Customer::where('phone', $searchValue)->first();
            return view('front.form', [
                'customer' => $customer,
                'phone' => $searchValue,
                'dollarRate' => $customer?->dollar_rate ?? 130
            ]);
        }
    }

    public function submitRequest(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'dollar_amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'transaction_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create or update customer
        $customer = Customer::updateOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'] ?? null,
            ]
        );

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('transaction_proof')) {
            $imagePath = $request->file('transaction_proof')->store('transaction_proofs', 'public');
        }

        $dollarRate = $customer->dollar_rate ?? 130;
        $totalCost = $validated['dollar_amount'] * $dollarRate;

        // Create dollar request
        $dollarRequest = \App\Models\DollarRequest::create([
            'customer_id' => $customer->id,
            'customer_name' => $validated['name'],
            'customer_email' => $validated['email'],
            'customer_phone' => $validated['phone'],
            'customer_address' => $validated['address'] ?? null,
            'payment_method' => $validated['payment_method'],
            'transaction_id' => $validated['transaction_id'] ?? null,
            'bank_name' => $validated['bank_name'] ?? null,
            'account_number' => $validated['account_number'] ?? null,
            'dollar_amount' => $validated['dollar_amount'],
            'dollar_rate' => $dollarRate,
            'total_cost' => $totalCost,
            'transaction_proof' => $imagePath,
            'status' => 'pending',
        ]);

        return redirect()->signedRoute('request.success', ['id' => $dollarRequest->id]);
    }

    public function requestSuccess($id)
    {
        $dollarRequest = \App\Models\DollarRequest::with('customer')->findOrFail($id);
        
        return view('front.success', [
            'customer' => $dollarRequest->customer,
            'dollarRequest' => $dollarRequest,
        ]);
    }
}
