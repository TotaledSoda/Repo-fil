<?php
use App\Models\Servicios;
use App\Models\HeroSlide;
use App\Models\about;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'servicios' => Servicios::all(),
        'heroSlides' => HeroSlide::orderBy('order', 'asc')->get()
    ]);
});

Route::get('/', function () {
    return view('welcome', [
        'heroSlides' => HeroSlide::orderBy('order', 'asc')->get(),
        'servicios' => Servicios::all(),
        'about' => about::first(), // Obtenemos el único registro existente
        'aboutSection' => About::first()
    ]);
});