@extends('layouts.app')
@section('title', $title)

@section('content')
    <div class="container mx-auto py-8 px-6 max-w-screen-xl lg:py-16 lg:px-2 ">
        <div class="mx-auto text-center mb-8 max-w-screen-sm lg:mb-16">
            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 cctext-white">Our Galeri</h2>
            <p class="font-light text-gray-500 sm:text-xl cctext-gray-400">Discover our company's moments, projects, and
                achievements. Explore our work culture, products, and events through our collection of images.</p>
        </div>
        @foreach ($new_galeries as $new)
            <div class="h-64 rounded-md overflow-hidden bg-cover bg-center"
                style="
                    background-image: url('{{ Storage::url($new->image) }}');">
                <div class="bg-gray-900 bg-opacity-50 flex items-center h-full">
                    <div class="px-10 max-w-xl">
                        <h2 class="text-2xl text-white font-semibold">{{ $new->name }}</h2>
                        <p class="mt-2 text-gray-400">
                            {{ $new->description }}
                        </p>
                        <button onclick="window.location.href='{{ route('front.photo', $new->slug) }}'"
                            class="flex items-center mt-4 px-3 py-2 bg-blue-600 text-white text-sm uppercase font-medium rounded hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                            <span>Shop Now</span>
                            <svg class="h-5 w-5 mx-2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="flex flex-wrap -mx-4 mt-8">
            @foreach ($galeries as $galeri)
                <div class="w-full md:w-1/2 lg:w-1/3 xl:w-1/4 px-4 mb-4">
                    <div class="h-64 rounded-md overflow-hidden bg-cover bg-center"
                        style="background-image: url('{{ Storage::url($galeri->image) }}');">
                        <div class="bg-gray-900 bg-opacity-50 flex items-center h-full">
                            <div class="px-6 max-w-xl">
                                <h2 class="text-2xl text-white font-semibold">{{ $galeri->name }}</h2>
                                <p class="mt-2 text-gray-400">
                                    {{ $galeri->description }}
                                </p>
                                <a href="{{ route('front.photo', $galeri->slug) }}"
                                    class="flex items-center mt-4 text-white text-sm uppercase font-medium rounded hover:underline focus:outline-none">
                                    <span>Shop Now</span>
                                    <svg class="h-5 w-5 mx-2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
