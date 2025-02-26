@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="pt-10  max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-12 lg:pt-16">
        <!-- Grid -->
        <div class="grid lg:grid-cols-7 lg:gap-x-8 xl:gap-x-12 lg:items-center">
            <div class="lg:col-span-3">
                <h1 class="block pb-5 text-3xl font-bold text-gray-800 sm:text-4xl md:text-5xl lg:text-6xl">About Us.
                </h1>
                <p class="mt-3 text-lg text-gray-800">
                    <strong>PT. Global Inspeksi Sertifikasi</strong> is a local company engaged in certification services
                    established in
                    October 2016 located in a commercial business area in the Tangerang area.
                    <br> <br>
                    In order to provide security from inappropriate use and to protect the public from the distribution of
                    products that do not meet the requirements for quality, safety and usefulness, it is necessary to assess
                    compliance with conformity standards. This is what motivates us, Global Inspeksi Sertifikasi, to come
                    together to support government regulations, industry partners and also consumer protection.
                    <br> <br>
                    In order to provide security is a group of personnel who have been established in the field of auditing
                    and certification of management systems and products. Global Inspeksi Sertifikasi also has good
                    relationships with government agencies, local and international partners who support the regulations set
                    by the Government.
                </p>

            </div>
            <!-- End Col -->

            <div class="lg:col-span-4 mt-10 lg:mt-0">
                <img class="w-full rounded-xl"
                    src="https://images.unsplash.com/photo-1665686376173-ada7a0031a85?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=900&h=700&q=80"
                    alt="Hero Image">
            </div>
            <!-- End Col -->
        </div>
        <!-- Brands -->
        <div class="mt-6 lg:mt-12">
            <span class="text-xs font-medium text-gray-800 uppercase">Our Partner</span>

            <div class="mt-4 flex gap-x-8">

                @foreach ($partners as $partner)
                    <div class="w-20 h-auto content-center">
                        <img src="{{ asset('storage/' . $partner->image) }}" alt="{{ $partner->name }}" class=" ">
                    </div>
                @endforeach

            </div>
        </div>
        <!-- End Brands -->
        <!-- End Grid -->
    </div>
    <!-- End Hero -->
    <!-- End Hero -->
@endsection
