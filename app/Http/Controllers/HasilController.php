<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Mahasiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    public function index()
    {
        $pola = session('pola', []);
        return view('hasil', compact('pola'));
    }

   
}

