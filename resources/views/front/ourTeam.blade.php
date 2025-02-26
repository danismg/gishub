@extends('layouts.app')
@section('title', $title)
@section('content')
    <section class="bg-white ccbg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-6">
            <div class="mx-auto mb-8 max-w-screen-sm lg:mb-16">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 cctext-white">Our team</h2>
                <p class="font-light text-gray-500 sm:text-xl cctext-gray-400">We're a dynamic group of individuals who
                    are passionate about what we do and dedicated to delivering the best results for our clients.</p>
            </div>
            <div class="grid gap-8 lg:gap-16 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">

                @foreach ($users as $user)
                    <div class="text-center text-gray-500 cctext-gray-400">
                        <img class="mx-auto mb-4 w-36 h-36 rounded-full" src="{{ Storage::url($user->avatar_url) }}"
                            alt="Bonnie Avatar">
                        <h3 class="mb-1 text-2xl font-bold tracking-tight text-gray-900 cctext-white">
                            <a href="#">{{ $user->name }}</a>
                        </h3>
                        <p>
                            {{-- role --}}
                            @foreach ($user->roles as $role)
                                {{ $role->name }}
                            @endforeach
                        </p>
                        <ul class="flex justify-center mt-4 space-x-4">
                            <li class="">
                                <a href="{{ $user->link_facebook }}"
                                    class="text-[#39569c] hover:text-gray-900 cchover:text-white">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="{{ $user->link_twitter }}"
                                    class="text-[#00acee] hover:text-gray-900 cchover:text-white">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path
                                            d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="{{ $user->link_instagram }}"
                                    class="text-[#E4405F] hover:text-gray-900 cchover:text-white">
                                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.308.975.975 1.246 2.242 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.308 3.608-.975.975-2.242 1.246-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.308-.975-.975-1.246-2.242-1.308-3.608C2.175 15.584 2.163 15.204 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.308-3.608.975-.975 2.242-1.246 3.608-1.308 1.266-.058 1.646-.07 4.85-.07m0-2.163C8.636 0 8.224.012 7.217.07 6.144.13 5.103.352 4.25.918c-.853.566-1.52 1.333-2.086 2.086-.566.853-.788 1.894-.848 2.967C.012 8.224 0 8.636 0 12s.012 3.776.07 4.783c.06 1.073.282 2.114.848 2.967.566.853 1.333 1.52 2.086 2.086.853.566 1.894.788 2.967.848C8.224 23.988 8.636 24 12 24s3.776-.012 4.783-.07c1.073-.06 2.114-.282 2.967-.848.853-.566 1.52-1.333 2.086-2.086.566-.853.788-1.894.848-2.967.058-1.007.07-1.419.07-4.783s-.012-3.776-.07-4.783c-.06-1.073-.282-2.114-.848-2.967-.566-.853-1.333-1.52-2.086-2.086-.853-.566-1.894-.788-2.967-.848C15.776.012 15.364 0 12 0zM12 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zm0 10.162a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-10.845a1.44 1.44 0 1 0 0 2.88 1.44 1.44 0 0 0 0-2.88z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </li>

                        </ul>
                    </div>
                @endforeach




            </div>
        </div>
    </section>
@endsection
