@extends('layouts.app')
@section('title', $title)
@section('content')
    <div class="container mx-auto py-8 px-6 max-w-screen-xl lg:py-16 lg:px-2 ">
        <div class="mx-auto text-center mb-8 max-w-screen-sm lg:mb-16">
            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 cctext-white">{{ $galeri->name }}</h2>
            <p class="font-light text-gray-500 sm:text-xl cctext-gray-400">Explore the whole {{ $galeri->description }}
            </p>
        </div>
        <div class="flex flex-wrap -mx-4 mt-8">
            {{-- @foreach ($galeries as $galeri) --}}


            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    // Inisialisasi array kosong untuk 4 kolom
                @endphp

                @foreach ($columns as $column)
                    <div class="grid gap-4">
                        @foreach ($column as $image)
                            <div>
                                <img class="h-auto max-w-full rounded-lg" src="{{ Storage::url($image) }}" alt="Gallery Image">
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>


            {{-- @endforeach --}}
        </div>
    @endsection
