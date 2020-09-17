<?php

namespace App\Http\Controllers;

use App\Models\Houseguest;
use Illuminate\Http\Request;

class HouseguestController extends Controller
{
    public function show(Houseguest $houseguest)
    {
        $houseguest->load([
            'prices',
            'ratings'
        ])->appendAttribute('projections');

        return view('houseguest.show', compact('houseguest'));
    }
}
