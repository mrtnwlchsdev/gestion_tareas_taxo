<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PrincipalController extends Controller
{
    public function index()
    {
        return Inertia::render('Pages/Principal');
    }
}
