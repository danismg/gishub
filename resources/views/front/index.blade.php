@extends('layouts.app')

@section('title', $title)

@section('content')
    <div x-data="{ cartOpen: false, isOpen: false }" class="bg-white">
        <!-- Header -->


        <section class="  bg-white dark:bg-gray-900">
            <div class=" px-4 py-8 mx-auto max-w-screen-xl text-center lg:pt-16 lg:px-8">
                <a href="#"
                    class="inline-flex justify-between items-center py-1 px-1 pr-4 mb-7 text-sm text-gray-700 bg-gray-100 rounded-full dark:bg-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700"
                    role="alert">
                    <span class="text-xs bg-primary-600 rounded-full text-white px-4 py-1.5 mr-3">New</span>
                    <span class="text-sm font-medium">New Certification Updates!</span>
                    <svg class="ml-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
                <h1
                    class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                    What awaits you after you join
                </h1>
                <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">
                    Enhancing quality and management systems, supporting national standards and efficiency, and being a
                    partner in technological development.
                </p>

                <!-- Clients -->
                <div class="max-w-[85rem] px-4 py-2 sm:px-1 lg:px-8 lg:py-0 mx-auto">

                    <!-- Grid -->
                    <div class="my-2 md:my-8 grid grid-cols-3 sm:flex sm:justify-center gap-6 sm:gap-x-12 lg:gap-x-20">
                        @foreach ($topclients as $topclient)
                            <a class="shrink-0 transition hover:-translate-y-1" href="#">
                                <img class="h-12 sm:h-16 mx-auto sm:mx-0"
                                    src="{{ Storage::url($topclient->client->image) }}" alt="Client Logo">
                            </a>
                        @endforeach
                    </div>
                    <!-- End Grid -->
                </div>
                <!-- End Clients -->

                <section class="pt-2 antialiased dark:bg-gray-900 md:pt-16">
                    <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
                        <div class="mb-4 flex items-center justify-between gap-4 md:mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">
                                Our Services
                            </h2>

                            <a href="{{ route('front.services') }}" title=""
                                class="flex items-center text-base font-medium text-primary-700 hover:underline dark:text-primary-500">
                                See more services
                                <svg class="ms-1 h-5 w-5" aria-hidden="true" Shop by category
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4" />
                                </svg>
                            </a>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                            @foreach ($services as $service)
                                <a href="#" class="card rounded-lg border border-gray-200">
                                    <div
                                        class="flex items-center h-full rounded-3xl p-3 pr-1 gap-3 bg-white dark:bg-gray-800 dark:hover:bg-gray-700">
                                        <img src="{{ Storage::url($service->image) }}"
                                            class="w-[56px] h-[56px] flex shrink-0" alt="icon" />
                                        <div class="flex flex-col gap-[2px] overflow-hidden text-left">
                                            <h3
                                                class="font-semibold text-sm leading-[27px] break-words text-gray-900 dark:text-white">
                                                {{ $service->sort_name }}
                                            </h3>
                                            <p class="font-small text-xs text-gray-500 dark:text-gray-400">
                                                {{ $service->name }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach


                        </div>
                    </div>
                </section>
            </div>
        </section>

        <div :class="cartOpen ? 'translate-x-0 ease-out' : 'translate-x-full ease-in'"
            class="fixed right-0 top-0 max-w-xs w-full h-full px-6 py-4 transition duration-300 transform overflow-y-auto bg-white border-l-2 border-gray-300">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-medium text-gray-700">Your cart</h3>
                <button @click="cartOpen = !cartOpen" class="text-gray-600 focus:outline-none">
                    <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <hr class="my-3" />
            <div class="flex justify-between mt-6">
                <div class="flex">
                    <img class="h-20 w-20 object-cover rounded"
                        src="https://images.unsplash.com/photo-1593642632823-8f785ba67e45?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1189&q=80"
                        alt="" />
                    <div class="mx-3">
                        <h3 class="text-sm text-gray-600">Mac Book Pro</h3>
                        <div class="flex items-center mt-2">
                            <button class="text-gray-500 focus:outline-none focus:text-gray-600">
                                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </button>
                            <span class="text-gray-700 mx-2">2</span>
                            <button class="text-gray-500 focus:outline-none focus:text-gray-600">
                                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <span class="text-gray-600">20$</span>
            </div>
            <div class="flex justify-between mt-6">
                <div class="flex">
                    <img class="h-20 w-20 object-cover rounded"
                        src="https://images.unsplash.com/photo-1593642632823-8f785ba67e45?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1189&q=80"
                        alt="" />
                    <div class="mx-3">
                        <h3 class="text-sm text-gray-600">Mac Book Pro</h3>
                        <div class="flex items-center mt-2">
                            <button class="text-gray-500 focus:outline-none focus:text-gray-600">
                                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </button>
                            <span class="text-gray-700 mx-2">2</span>
                            <button class="text-gray-500 focus:outline-none focus:text-gray-600">
                                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <span class="text-gray-600">20$</span>
            </div>
            <div class="flex justify-between mt-6">
                <div class="flex">
                    <img class="h-20 w-20 object-cover rounded"
                        src="https://images.unsplash.com/photo-1593642632823-8f785ba67e45?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1189&q=80"
                        alt="" />
                    <div class="mx-3">
                        <h3 class="text-sm text-gray-600">Mac Book Pro</h3>
                        <div class="flex items-center mt-2">
                            <button class="text-gray-500 focus:outline-none focus:text-gray-600">
                                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </button>
                            <span class="text-gray-700 mx-2">2</span>
                            <button class="text-gray-500 focus:outline-none focus:text-gray-600">
                                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <span class="text-gray-600">20$</span>
            </div>
            <div class="mt-8">
                <form class="flex items-center justify-center">
                    <input class="form-input w-48" type="text" placeholder="Add promocode" />
                    <button
                        class="ml-3 flex items-center px-3 py-2 bg-blue-600 text-white text-sm uppercase font-medium rounded hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                        <span>Apply</span>
                    </button>
                </form>
            </div>
            <a
                class="flex items-center justify-center mt-4 px-3 py-2 bg-blue-600 text-white text-sm uppercase font-medium rounded hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                <span>Chechout</span>
                <svg class="h-5 w-5 mx-2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
        <main class="my-8 px-4 mx-auto max-w-screen-xl lg:py-0 lg:px-2">
            <div class="container mx-auto px-6">
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
                                <button
                                    class="flex items-center mt-4 px-3 py-2 bg-blue-600 text-white text-sm uppercase font-medium rounded hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                                    <span>Shop Now</span>
                                    <svg class="h-5 w-5 mx-2" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                        stroke="currentColor">
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
                                        <button
                                            class="flex items-center mt-4 text-white text-sm uppercase font-medium rounded hover:underline focus:outline-none">
                                            <span>Shop Now</span>
                                            <svg class="h-5 w-5 mx-2" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <section class="bg-white dark:bg-gray-900">
                    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 ">
                        <div class="mx-auto max-w-screen-sm text-center mb-8 lg:mb-16">
                            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">
                                Our Team
                            </h2>
                            <p class="font-light text-gray-500 lg:mb-16 sm:text-xl dark:text-gray-400">
                                Our team is a group of passionate professionals dedicated to
                                innovation, collaboration, and excellence to drive meaningful
                                impact.
                            </p>
                        </div>
                        <div class="grid gap-8 mb-6 lg:mb-16 md:grid-cols-2">
                            {{-- card --}}
                            @foreach ($tops as $top)
                                <div
                                    class="items-center bg-gray-50 rounded-lg shadow sm:flex dark:bg-gray-800 dark:border-gray-700">
                                    <a href="#" class="w-2/5">
                                        <img class="w-full h-auto rounded-lg sm:rounded-none sm:rounded-l-lg"
                                            src="{{ Storage::url($top->user->avatar_url) }}"
                                            alt="Avatar-{{ $top->user->name }}" />
                                    </a>
                                    <div class="p-5">
                                        <h3 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                                            <a href="#">{{ $top->user->name }}</a>
                                        </h3>
                                        <span class="text-gray-500 dark:text-gray-400">
                                            @foreach ($top->user->roles as $role)
                                                {{ $role->name }}
                                            @endforeach
                                        </span>
                                        <p class="mt-3 mb-4 font-light text-gray-500 dark:text-gray-400">
                                            {{ $top->description }}
                                        </p>
                                        <ul class="flex space-x-4 sm:mt-0">
                                            <li>
                                                <a href="{{ $top->user->link_facebook }}"
                                                    class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"
                                                        aria-hidden="true">
                                                        <path fill-rule="evenodd"
                                                            d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ $top->user->link_twitter }}"
                                                    class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"
                                                        aria-hidden="true">
                                                        <path
                                                            d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                                    </svg>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ $top->user->link_instagram }}"
                                                    class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 32 32"
                                                        aria-hidden="true">
                                                        <path fill-rule="evenodd"
                                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.308.975.975 1.246 2.242 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.308 3.608-.975.975-2.242 1.246-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.308-.975-.975-1.246-2.242-1.308-3.608C2.175 15.584 2.163 15.204 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.308-3.608.975-.975 2.242-1.246 3.608-1.308 1.266-.058 1.646-.07 4.85-.07m0-2.163C8.636 0 8.224.012 7.217.07 6.144.13 5.103.352 4.25.918c-.853.566-1.52 1.333-2.086 2.086-.566.853-.788 1.894-.848 2.967C.012 8.224 0 8.636 0 12s.012 3.776.07 4.783c.06 1.073.282 2.114.848 2.967.566.853 1.333 1.52 2.086 2.086.853.566 1.894.788 2.967.848C8.224 23.988 8.636 24 12 24s3.776-.012 4.783-.07c1.073-.06 2.114-.282 2.967-.848.853-.566 1.52-1.333 2.086-2.086.566-.853.788-1.894.848-2.967.058-1.007.07-1.419.07-4.783s-.012-3.776-.07-4.783c-.06-1.073-.282-2.114-.848-2.967-.566-.853-1.333-1.52-2.086-2.086-.853-.566-1.894-.788-2.967-.848C15.776.012 15.364 0 12 0zM12 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zm0 10.162a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-10.845a1.44 1.44 0 1 0 0 2.88 1.44 1.44 0 0 0 0-2.88z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </section>
            </div>
        </main>



    </div>
@endsection
