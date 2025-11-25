@extends('layouts.app')
@section('title', 'Welcome')
@section('content')

<div class="max-w-4xl mx-auto space-y-4 sm:space-y-8 px-4 py-8 sm:px-0">

    {{-- Professional Header --}}
    <div class="text-center mb-4 sm:mb-8">
        <div class="inline-block bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-2 sm:px-6 sm:py-3 rounded-full mb-2 sm:mb-4">
            <h1 class="text-lg sm:text-2xl font-bold">Dollar Purchase Request</h1>
        </div>
        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Complete the form below to submit your dollar purchase request</p>
    </div>

    {{-- Step 1: Email or Phone Search --}}
    @if(!isset($customer) && !isset($email) && !isset($phone))
    <div class="bg-white dark:bg-gray-800 rounded-lg sm:rounded-xl shadow-lg p-3 sm:p-8 border border-gray-100 dark:border-gray-700">
        <div class="flex items-center mb-4 sm:mb-6">
            <div class="bg-indigo-100 dark:bg-indigo-900 rounded-full p-2 sm:p-3 mr-3 sm:mr-4">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <h2 class="text-base sm:text-xl font-semibold text-gray-900 dark:text-white">Search by Email or Phone</h2>
        </div>
        <form action="{{ url('/search-customer') }}" method="GET" class="flex flex-col sm:flex-row gap-3 sm:gap-4">
            <input type="text"
                   name="search_value"
                   required
                   class="flex-1 border-2 border-gray-200 dark:border-gray-600 rounded-lg px-4 py-2.5 sm:px-5 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                   placeholder="Enter your email or phone number">
            <button type="submit" class="bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-semibold px-6 py-2.5 sm:px-8 sm:py-3 text-sm sm:text-base rounded-lg shadow-md hover:shadow-lg transition-all">
                Search
            </button>
        </form>
    </div>
    @endif

    {{-- Step 2: Customer Form + Dollar Purchase --}}
    @if(isset($email) || isset($phone))
    <form action="{{ url('/submit-request') }}" method="POST" enctype="multipart/form-data" class="space-y-4 sm:space-y-6">
        @csrf

        {{-- Customer Information --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg sm:rounded-xl shadow-lg p-3 sm:p-8 border border-gray-100 dark:border-gray-700">
            <div class="flex items-center mb-4 sm:mb-6">
                <div class="bg-green-100 dark:bg-green-900 rounded-full p-2 sm:p-3 mr-3 sm:mr-4">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h2 class="text-base sm:text-xl font-semibold text-gray-900 dark:text-white">
                    @if($customer)
                        Welcome Back, {{ $customer->name }}!
                    @else
                        New Customer Registration
                    @endif
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email</label>
                    <input type="email" name="email" value="{{ $email ?? $customer->email ?? '' }}" {{ ($customer || isset($email)) ? 'readonly' : 'required' }}
                           class="w-full border-2 border-gray-200 dark:border-gray-600 rounded-lg px-4 py-3 {{ ($customer || isset($email)) ? 'bg-gray-50 dark:bg-gray-700 text-gray-500' : '' }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                    <input type="text" name="name" value="{{ $customer->name ?? '' }}" required
                           class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           {{ $customer ? 'readonly' : '' }}>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Phone</label>
                    <input type="text" name="phone" value="{{ $phone ?? $customer->phone ?? '' }}" {{ ($customer || isset($phone)) ? 'readonly' : 'required' }}
                           class="w-full border-2 border-gray-200 dark:border-gray-600 rounded-lg px-4 py-3 {{ ($customer || isset($phone)) ? 'bg-gray-50 dark:bg-gray-700 text-gray-500' : '' }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" name="address" value="{{ $customer->address ?? '' }}"
                           class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           {{ $customer ? 'readonly' : '' }}>
                </div>
            </div>
        </div>

        {{-- Dollar Purchase --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg sm:rounded-xl shadow-lg p-3 sm:p-8 border border-gray-100 dark:border-gray-700">
            <div class="flex items-center mb-4 sm:mb-6">
                <div class="bg-blue-100 dark:bg-blue-900 rounded-full p-2 sm:p-3 mr-3 sm:mr-4">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Dollar Purchase Details</h2>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dollar Amount *</label>
                    <input type="number" 
                           name="dollar_amount" 
                           id="dollarAmount"
                           step="0.01" 
                           min="1" 
                           required
                           class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           placeholder="Enter dollar amount"
                           oninput="calculateTotal()">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method *</label>
                    <select name="payment_method" 
                            required
                            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select payment method</option>
                        <option value="bkash">bKash</option>
                        <option value="nagad">Nagad</option>
                        <option value="rocket">Rocket</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="cash">Cash</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Transaction ID</label>
                    <input type="text" 
                           name="transaction_id" 
                           class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           placeholder="Enter transaction ID">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Account Number</label>
                    <input type="text" 
                           name="account_number" 
                           id="accountNumber"
                           class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           placeholder="Enter account number">
                </div>

                <div id="bankFields" style="display: none;">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bank Name</label>
                        <input type="text" 
                               name="bank_name" 
                               id="bankName"
                               class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                               placeholder="Enter bank name">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Transaction Proof (Image)</label>
                    <input type="file" 
                           name="transaction_proof" 
                           id="transactionProof"
                           accept="image/*"
                           onchange="previewImage(event)"
                           class="w-full border-2 border-gray-200 dark:border-gray-600 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Upload payment screenshot or transaction proof (Max: 2MB)</p>
                    
                    <!-- Image Preview -->
                    <div id="imagePreview" class="mt-4" style="display: none;">
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border-2 border-dashed border-gray-300 dark:border-gray-600">
                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Preview:</p>
                            <img id="preview" src="" alt="Image preview" class="max-w-full h-auto rounded-lg shadow-md">
                        </div>
                    </div>
                </div>

                <!-- Calculation Summary -->
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 p-6 rounded-xl border-2 border-indigo-200 dark:border-indigo-700 shadow-sm">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Exchange Rate:</span>
                        <span class="font-semibold">৳{{ $dollarRate ?? 130 }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold border-t pt-2">
                        <span>Total Cost:</span>
                        <span class="text-indigo-600" id="totalCost">৳0.00</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 pt-4">
            <a href="{{ url('/request-form') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold px-6 py-3 sm:px-8 sm:py-4 text-sm sm:text-base rounded-lg text-center transition-all shadow-sm hover:shadow-md">
                Cancel
            </a>
            <button type="submit" class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold px-6 py-3 sm:px-8 sm:py-4 text-sm sm:text-base rounded-lg shadow-md hover:shadow-xl transition-all">
                Submit Request
            </button>
        </div>
    </form>
    @endif

</div>

<script>
    // Live image preview
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview');
        const imagePreview = document.getElementById('imagePreview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                imagePreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
        }
    }

    function calculateTotal() {
        const dollarAmount = parseFloat(document.getElementById('dollarAmount').value) || 0;
        const rate = {{ $dollarRate ?? 130 }};
        const total = dollarAmount * rate;
        document.getElementById('totalCost').textContent = '৳' + total.toFixed(2);
    }

    // Show/hide bank fields based on payment method
    document.addEventListener('DOMContentLoaded', function() {
        const paymentMethod = document.querySelector('select[name="payment_method"]');
        const bankFields = document.getElementById('bankFields');
        const bankName = document.getElementById('bankName');
        const accountNumber = document.getElementById('accountNumber');

        if (paymentMethod) {
            paymentMethod.addEventListener('change', function() {
                if (this.value === 'bank_transfer') {
                    bankFields.style.display = 'block';
                    bankName.required = true;
                    accountNumber.required = true;
                } else {
                    bankFields.style.display = 'none';
                    bankName.required = false;
                    accountNumber.required = false;
                }
            });
        }
    });
</script>

@endsection

