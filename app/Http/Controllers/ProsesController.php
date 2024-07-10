<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class ProsesController extends Controller
{
    public function index()
    {
        return view('proses');
    }

    public function calculate(Request $request)
    {
        $min_support = $request->input('min_support');
        $min_confidence = $request->input('min_confidence');

        $pola = $this->findPatterns($min_support, $min_confidence);
       

        return redirect()->route('hasil.index')->with('pola', $pola);
    }

    private function findPatterns($min_support, $min_confidence)
    {
        $mahasiswas = Mahasiswa::all();
        $total_mahasiswa = $mahasiswas->count();

        $patterns = [];
        
        // Menghitung frekuensi setiap kombinasi nilai
        foreach ($mahasiswas as $mahasiswa) {
            $patterns[$mahasiswa->tajwid][$mahasiswa->fashohah][$mahasiswa->adab][] = $mahasiswa->id;
        }
      

        $result = [];

        foreach ($patterns as $tajwid => $fashohahData) {
            foreach ($fashohahData as $fashohah => $adabData) {
                foreach ($adabData as $adab => $mahasiswaIds) {
                    $support = count($mahasiswaIds) / $total_mahasiswa;

                    if ($support >= $min_support) {
                        $result[] = [
                            'pola' => "Tajwid: $tajwid, Fashohah: $fashohah, Adab: $adab",
                            'support' => $support,
                            'confidence' => 1 
                        ];
                    }
                }
            }
        }


        return $result;
    }
}
