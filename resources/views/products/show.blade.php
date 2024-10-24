@extends('layouts.base')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6">
            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                class="w-full h-48 object-cover object-center mb-4">
            <h2 class="text-lg font-medium text-gray-800">{{ $product->name }}</h2>
            <p class="text-sm text-gray-600">{{ $product->description }}</p>
            <p class="text-lg font-medium text-gray-800 mt-2">&#8358;{{ $product->price }}</p>

            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">Add to
                    Cart</button>
                <a href="{{ route('products.index') }}" class="bg-green-400 rounded-lg p-2 mt-4">Back</a>
            </div>
        </div>
    </div>
@endsection
