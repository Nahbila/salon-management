<?php

namespace App\Http\Controllers;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing', [
            'photos' => [
                'hero_woman' => $this->photo('hero-woman'),
                'hero_man' => $this->photo('hero-man'),
                'about' => $this->photo('about'),
                'women' => $this->photo('women'),
                'men' => $this->photo('men'),
                'custom' => $this->photo('custom'),
            ],
        ]);
    }

    private function photo(string $name): ?string
    {
        foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
            if (file_exists(public_path("images/landing/{$name}.{$ext}"))) {
                return asset("images/landing/{$name}.{$ext}");
            }
        }

        return null;
    }
}