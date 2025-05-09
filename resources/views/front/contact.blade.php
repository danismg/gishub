@extends('layouts.app')

@section('title', $title)

@section('content')
    <section class="bg-white ccbg-gray-900">
        <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 cctext-white">Contact Us</h2>
            <p class="mb-8 lg:mb-16 font-light text-center text-gray-500 cctext-gray-400 sm:text-xl">If you have any
                questions or suggestions regarding the information we provide, feel free to contact us.</p>
            <form method="POST" action="{{ route('front.inbox') }}" class="space-y-8"enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 cctext-gray-300">Your
                        email</label>
                    <input type="email" id="email" name="email"
                        class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 ccbg-gray-700 ccborder-gray-600 ccplaceholder-gray-400 cctext-white ccfocus:ring-primary-500 ccfocus:border-primary-500 ccshadow-sm-light"
                        placeholder="yourname@gmail.com" required>
                </div>
                <div>
                    <label for="subject"
                        class="block mb-2 text-sm font-medium text-gray-900 cctext-gray-300">Subject</label>
                    <input type="text" id,="subject" name="subject"
                        class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 ccbg-gray-700 ccborder-gray-600 ccplaceholder-gray-400 cctext-white ccfocus:ring-primary-500 ccfocus:border-primary-500 ccshadow-sm-light"
                        placeholder="Let us know how we can help you" required>
                </div>
                <div class="sm:col-span-2">
                    <label for="message" class="block mb-2 text-sm font-medium text-gray-900 cctext-gray-400">Your
                        message</label>
                    <textarea id="message" rows="6" name="message"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 ccbg-gray-700 ccborder-gray-600 ccplaceholder-gray-400 cctext-white ccfocus:ring-primary-500 ccfocus:border-primary-500"
                        placeholder="Leave a comment..."></textarea>
                </div>
                <button type="submit"
                    class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-primary-700 sm:w-fit hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 ccbg-primary-600 cchover:bg-primary-700 ccfocus:ring-primary-800">Send
                    message</button>
            </form>
        </div>
    </section>
@endsection
