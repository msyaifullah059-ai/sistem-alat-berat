<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Service;
use App\Models\Alat;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $abouts = About::all();
        $services = Service::all();
        $tools = AlatBerat::all();

        return view('profile.index', compact('abouts', 'services', 'tools'));
    }
}
