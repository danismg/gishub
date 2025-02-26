@extends('layouts.app')
@section('title', $title)
@section('content')
    <section class="bg-white ccbg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-6">
            <div class="mx-auto mb-8 max-w-screen-sm lg:mb-16">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 cctext-white">Our Services</h2>
                <p class="font-light text-gray-500 sm:text-xl cctext-gray-400">Explore the We offer a diverse collection
                    of open-source web components and elements built with Tailwind's utility classes.</p>
            </div>


            <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($services as $service)
                    <a href="#" class="card rounded-lg border border-gray-200">
                        <div
                            class="flex items-center h-full rounded-3xl p-3 pr-1 gap-3 bg-white ccbg-gray-800 cchover:bg-gray-700">
                            <img src="{{ Storage::url($service->image) }}" class="w-[56px] h-[56px] flex shrink-0"
                                alt="icon" />
                            <div class="flex flex-col gap-[2px] overflow-hidden text-left">
                                <h3 class="font-semibold text-sm leading-[27px] break-words text-gray-900 cctext-white">
                                    {{ $service->sort_name }}
                                </h3>
                                <p class="font-small text-xs text-gray-500 cctext-gray-400">
                                    {{ $service->name }}
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach

            </div>
        </div>
    </section>
@endsection
