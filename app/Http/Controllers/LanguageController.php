<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch(Request $request, string $locale)
    {
        $supported = config('app.available_locales', ['en']);

        if (in_array($locale, $supported)) {
            // Store chosen locale in session — middleware will read it on every request
            session(['locale' => $locale]);
        }

        // Go back to the page the user was on
        return redirect()->back();
    }
}