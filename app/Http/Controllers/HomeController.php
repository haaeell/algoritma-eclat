<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $angkatans = Mahasiswa::select('angkatan')
            ->distinct()
            ->orderBy('angkatan')
            ->get()
            ->pluck('angkatan');
    
        $data = [];
        $totalPersentaseTidakLulus = 0;
        $angkatanCount = $angkatans->count();
    
        foreach ($angkatans as $angkatan) {
            $totalMahasiswa = Mahasiswa::where('angkatan', $angkatan)->count();
    
            $jumlahTidakLulus = Mahasiswa::where('angkatan', $angkatan)
                ->where(function($query) {
                    $query->where('status', 'TIDAK LULUS (D)')
                          ->orWhere('status', 'TIDAK LULUS (E)');
                })
                ->count();
    
            $persentaseTidakLulus = ($totalMahasiswa > 0) ? ($jumlahTidakLulus / $totalMahasiswa) * 100 : 0;
    
            $totalPersentaseTidakLulus += $persentaseTidakLulus;
    
            $data[] = [
                'angkatan' => $angkatan,
                'jumlah_tidak_lulus' => $jumlahTidakLulus,
                'total_mahasiswa' => $totalMahasiswa,
                'persentase_tidak_lulus' => number_format($persentaseTidakLulus, 2),
            ];
        }
    
        $rataRataPersentase = ($angkatanCount > 0) ? $totalPersentaseTidakLulus / $angkatanCount : 0;
        $rataRataPersentase = number_format($rataRataPersentase, 2);
    
        return view('home', compact('data', 'rataRataPersentase'));
    }
    
}
