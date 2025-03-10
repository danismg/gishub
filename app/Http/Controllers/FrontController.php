<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Client;
use App\Models\Galeri;
use App\Models\Inbox;
use App\Models\Partner;
use App\Models\Service;
use App\Models\Top;
use App\Models\TopClient;
use App\Models\User;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $title = 'Home';
        $services = Service::all();
        $topclients = TopClient::orderBy('id', 'desc')->take(8)->get();

        // get galeri 4 data
        $new_galeries = Galeri::orderBy('id', 'desc')->take(1)->get();


        // get galeri selain data diatas
        $galeries = Galeri::orderBy('id', 'desc')->skip(1)->take(4)->get();
        // galeries description max 100 character sisanya titik titik
        foreach ($galeries as $galeri) {
            $galeri->description = substr($galeri->description, 0, 100) . '...';
        }

        // tops
        $tops = Top::orderBy('id', 'desc')->take(4)->get();
        return view('front.index', compact('title', 'services', 'galeries', 'new_galeries', 'tops', 'topclients'));
    }

    public function ourTeam()
    {
        $title = 'Our Team';
        // user kecuali namanya admin
        $users = User::where('name', '!=', 'admin')->get();
        return view('front.ourTeam', compact('title', 'users'));
    }

    public function gallery()
    {

        $title = 'Gallery';
        $new_galeries = Galeri::orderBy('id', 'desc')->take(1)->get();
        $galeries = Galeri::orderBy('id', 'desc')->skip(1)->take(PHP_INT_MAX)->get();

        foreach ($galeries as $galeri) {
            $galeri->description = substr($galeri->description, 0, 100) . '...';
        }
        return view('front.gallery', compact('title', 'galeries', 'new_galeries'));
    }

    public function services()
    {
        $title = 'Services';
        $services = Service::all();
        return view('front.services', compact('title', 'services'));
    }

    public function aboutUs()
    {
        $title = 'About Us';
        $partners = Partner::all();
        return view('front.aboutUs', compact('title', 'partners'));
    }

    public function client()
    {
        $title = 'Client';
        $clients = Client::all();
        return view('front.client', compact('title', 'clients'));
    }

    public function contact()
    {
        $title = 'Contact';
        return view('front.contact', compact('title'));
    }

    public function inbox(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ]);

        // Simpan data ke database
        Inbox::create($request->only(['email', 'subject', 'message']));

        return redirect()->back()->with('success', 'Pesan berhasil dikirim');
    }


    public function photo(Galeri $galeri)
    {
        $title = 'Photo';
        // Ambil foto yang berkaitan dengan galeri yang dipilih
        $photos = $galeri->photos; // Pastikan ada relasi `photos` di model Galeri

        // Inisialisasi array untuk 4 kolom
        $columns = [
            [],
            [],
            [],
            []
        ];

        // Pastikan semua foto dikumpulkan dalam satu array
        $allPhotos = $photos->flatMap(function ($photo) {
            return is_array($photo->image) ? $photo->image : json_decode($photo->image, true);
        });

        // Distribusi gambar ke dalam 4 kolom
        foreach ($allPhotos as $index => $image) {
            $columns[$index % 4][] = $image;
        }

        return view('front.photo', compact('title', 'galeri', 'columns'));
    }

    public function logout()
    {
        $title = 'Home';
        auth()->logout();
        return redirect()->route('front.index');
    }
}
