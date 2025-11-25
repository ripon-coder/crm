@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="relative overflow-hidden">
    {{-- Background Elements --}}
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
        <div class="absolute -top-[30%] -left-[10%] w-[70%] h-[70%] rounded-full bg-purple-200/30 dark:bg-purple-900/20 blur-3xl filter"></div>
        <div class="absolute top-[20%] -right-[10%] w-[60%] h-[60%] rounded-full bg-indigo-200/30 dark:bg-indigo-900/20 blur-3xl filter"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-16 sm:pt-24 sm:pb-24">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-5xl sm:text-7xl font-extrabold text-gray-900 dark:text-white tracking-tight mb-8 leading-tight">
                Seamless Dollar <br class="hidden sm:block" />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Transactions & Management</span>
            </h1>
            
            <p class="text-xl sm:text-2xl text-gray-600 dark:text-gray-300 mb-10 max-w-2xl mx-auto leading-relaxed">
                Experience the future of currency management. Secure, fast, and reliable dollar purchase requests tailored for your business needs.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-6 mb-16">
                <a href="{{ url('/dollar-request-form') }}" 
                   class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-white transition-all duration-200 bg-indigo-600 rounded-full hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg hover:shadow-xl hover:-translate-y-1 overflow-hidden">
                    <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-indigo-600 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></span>
                    <span class="relative flex items-center">
                        Start New Request
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </span>
                </a>
                
            </div>
        </div>

        {{-- Feature Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
            <!-- Card 1 -->
            <div class="group p-8 bg-white/50 dark:bg-gray-800/50 backdrop-blur-lg rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Lightning Fast</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Instant processing of your requests with our automated system. Get your dollars when you need them.
                </p>
            </div>

            <!-- Card 2 -->
            <div class="group p-8 bg-white/50 dark:bg-gray-800/50 backdrop-blur-lg rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Bank-Grade Security</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Your transactions are protected with enterprise-level security and verified proof of payment.
                </p>
            </div>

            <!-- Card 3 -->
            <div class="group p-8 bg-white/50 dark:bg-gray-800/50 backdrop-blur-lg rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Premium Support</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Dedicated support team available 24/7 to assist you with any inquiries or transaction details.
                </p>
            </div>
        </div>


    </div>
</div>
@endsection
