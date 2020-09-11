<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function show()
    {
        return view('faq', [
            'season' => Season::current()
        ]);
    }
}
