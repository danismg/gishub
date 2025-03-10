@extends('layouts.app')

@section('title', $title)

@section('content')
    <section class="bg-white ccbg-gray-900">
        <div class="pt-8 px-4 mx-auto max-w-screen-xl text-center lg:pt-16 lg:px-6">
            <div class="mx-auto mb-8 max-w-screen-sm lg:mb-16">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 cctext-white">Our Clients</h2>
                <p class="font-light text-gray-500 sm:text-xl cctext-gray-400">We are proud to collaborate with amazing
                    clients who trust our services. Their success is our motivation to keep delivering the best.</p>
            </div>

        </div>

        <!-- Clients -->
        <div class="max-w-[85rem] px-4 sm:px-6 lg:px-8 lg:py-2 mx-auto"> <!-- End Title -->

            <!-- Grid -->
            <div class="grid lg:grid-cols-4 sm:grid-cols-2 md:grid-cols-5 gap-3 lg:gap-6">
                @foreach ($clients as $client)
                    <div class="p-4 md:p-7 bg-gray-100 rounded-lg">
                        {{-- Bualtah iamge dengan format yang sama dengan svg yang ada di bawah  --}}
                        <img src="{{ Storage::url($client->image) }}" alt="{{ $client->name }}"
                            class="w-16 h-auto md:w-20 lg:w-24 mx-auto">
                    </div>
                @endforeach
            </div>
            <!-- End Grid -->
        </div>
        <!-- End Clients -->


    </section>
@endsection
