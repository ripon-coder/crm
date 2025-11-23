@extends('layouts.app')
@section('title', 'Request Submitted')
@section('content')

<div class="max-w-2xl mx-auto">
    <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
        <div class="flex items-center">
            <svg class="w-12 h-12 text-green-600 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h1 class="text-2xl font-bold text-green-900">Request Submitted Successfully!</h1>
                <p class="text-green-700 mt-1">Your dollar purchase request has been received.</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 space-y-6">
        <div>
            <h2 class="text-lg font-semibold mb-4">Request Details</h2>
            
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-600">Request ID:</span>
                    <span class="font-semibold ml-2">#{{ $dollarRequest->id }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Status:</span>
                    <span class="ml-2 px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-semibold uppercase">
                        {{ $dollarRequest->status }}
                    </span>
                </div>
                <div>
                    <span class="text-gray-600">Customer:</span>
                    <span class="font-semibold ml-2">{{ $customer->name }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Email:</span>
                    <span class="font-semibold ml-2">{{ $customer->email }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Phone:</span>
                    <span class="font-semibold ml-2">{{ $customer->phone }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Payment Method:</span>
                    <span class="font-semibold ml-2 uppercase">{{ $dollarRequest->payment_method }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Transaction ID:</span>
                    <span class="font-semibold ml-2">{{ $dollarRequest->transaction_id }}</span>
                </div>
                @if($dollarRequest->bank_name)
                <div>
                    <span class="text-gray-600">Bank Name:</span>
                    <span class="font-semibold ml-2">{{ $dollarRequest->bank_name }}</span>
                </div>
                @endif
                @if($dollarRequest->account_number)
                <div>
                    <span class="text-gray-600">Account Number:</span>
                    <span class="font-semibold ml-2">{{ $dollarRequest->account_number }}</span>
                </div>
                @endif
                <div>
                    <span class="text-gray-600">Dollar Amount:</span>
                    <span class="font-semibold ml-2">${{ number_format($dollarRequest->dollar_amount, 2) }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Exchange Rate:</span>
                    <span class="font-semibold ml-2">৳{{ number_format($dollarRequest->dollar_rate, 2) }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Total Cost:</span>
                    <span class="font-semibold ml-2 text-indigo-600">৳{{ number_format($dollarRequest->total_cost, 2) }}</span>
                </div>
            </div>
        </div>

        @if($dollarRequest->transaction_proof)
        <div>
            <h3 class="text-sm font-semibold mb-2">Transaction Proof</h3>
            <img src="{{ asset('storage/' . $dollarRequest->transaction_proof) }}" 
                 alt="Transaction Proof" 
                 class="max-w-md rounded border border-gray-300">
        </div>
        @endif

        <div class="bg-blue-50 border border-blue-200 rounded p-4">
            <p class="text-sm text-blue-900">
                <strong>What's Next?</strong><br>
                Our team will review your request and contact you within 24 hours. Please keep your phone accessible.
            </p>
        </div>

        <div class="flex gap-3">
            <a href="{{ url('/request-form') }}" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded text-center">
                Make Another Request
            </a>
        </div>
    </div>
</div>

@endsection
