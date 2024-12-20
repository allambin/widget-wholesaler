<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Pack;

class HomeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Home/Index', [
            'packs' => Pack::all(),
            'buyUrl' => route('widgets.buy')
        ]);
    }
}
