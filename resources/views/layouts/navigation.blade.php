<header class=" fixed top-0 left-0 w-full ">
    <nav class="bg-white border-gray-200 px-4 lg:px-6 py-5 ccbg-gray-800">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
            <a href="/" class="flex items-center">
                <img src="{{ asset('img/logo_gis.png') }}" class="mr-3 h-6 sm:h-9" alt="Flowbite Logo" />

                <span class="self-center text-xl font-semibold whitespace-nowrap cctext-white">GISHub</span>
            </a>
            <div class="flex items-center lg:order-2">
                @auth
                    <a href="{{ route('front.logout') }}"
                        class="
                     text-white bg-red-700 hover:bg-red-800 focus:ring-red-300  ccbg-red-600 cchover:bg-red-700 ccfocus:ring-red-900
                       focus:ring-4 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2  focus:outline-none  "
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <a href="/admin"
                        class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 ccbg-primary-600 cchover:bg-primary-700 focus:outline-none ccfocus:ring-primary-800">
                        Dashboard
                    </a>
                    <form id="logout-form" action="{{ route('front.logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                @else
                    <a href="/admin"
                        class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 ccbg-primary-600 cchover:bg-primary-700 focus:outline-none ccfocus:ring-primary-800">
                        Log in
                    </a>
                @endauth

                <button data-collapse-toggle="mobile-menu-2" type="button"
                    class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 cctext-gray-400 cchover:bg-gray-700 ccfocus:ring-gray-600"
                    aria-controls="mobile-menu-2" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                    <li>
                        <a href="{{ url('/') }}"
                            class="block py-2 pr-4 pl-3 {{ request()->is('/') ? 'text-white rounded bg-primary-700 lg:bg-transparent lg:text-primary-700' : 'text-gray-700 hover:text-primary-700' }}">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('front.ourTeam') }}"
                            class="block py-2 pr-4 pl-3 {{ request()->routeIs('front.ourTeam') ? 'text-white rounded bg-primary-700 lg:bg-transparent lg:text-primary-700' : 'text-gray-700 hover:text-primary-700' }}">
                            Our Team
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('front.gallery') }}"
                            class="block py-2 pr-4 pl-3 {{ request()->routeIs('front.gallery') ? 'text-white rounded bg-primary-700 lg:bg-transparent lg:text-primary-700' : 'text-gray-700 hover:text-primary-700' }}">
                            Galeri
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('front.aboutUs') }}"
                            class="block py-2 pr-4 pl-3 {{ request()->routeIs('front.aboutUs') ? 'text-white rounded bg-primary-700 lg:bg-transparent lg:text-primary-700' : 'text-gray-700 hover:text-primary-700' }}">
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('front.contact') }}"
                            class="block py-2 pr-4 pl-3 {{ request()->routeIs('front.contact') ? 'text-white rounded bg-primary-700 lg:bg-transparent lg:text-primary-700' : 'text-gray-700 hover:text-primary-700' }}">
                            Contact
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
