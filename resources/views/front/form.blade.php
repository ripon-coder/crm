@extends('layouts.app')

@section('title', 'Welcome')
@section('header', 'Welcome Page')

@section('content')

<div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow">

    <form action="#" method="GET" class="flex gap-3">
        
        {{-- Left Side: Email Input --}}
        <input type="email"
               name="email"
               class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
               placeholder="Enter email">

        {{-- Right Side: Search Button --}}
        <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 rounded">
            Search
        </button>

    </form>

</div>

@endsection

