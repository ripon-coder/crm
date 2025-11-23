@extends('layouts.app')
@section('title', 'Welcome')
@section('content')

<div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow">

    <form action="#" method="GET" class="flex gap-3">
        
        {{-- Left Side: Email Input --}}
        <input type="email"
               name="email"
               class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
               placeholder="Enter email">

        {{-- Right Side: Search Button --}}
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded">
            Search
        </button>

    </form>

</div>

@endsection

