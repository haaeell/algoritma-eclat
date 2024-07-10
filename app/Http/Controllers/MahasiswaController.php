<?php

namespace App\Http\Controllers;

use App\Imports\MahasiswaImport;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::all();
        return view('mahasiswa.index', compact('mahasiswas'));
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswa,nim',
            'prodi' => 'required',
            'angkatan' => 'required',
            'jenis_kelamin' => 'required',
            'tajwid' => 'nullable|numeric',
            'fashohah' => 'nullable|numeric',
            'adab' => 'nullable|numeric',
        ]);

        $mahasiswa = new Mahasiswa($request->all());
        $mahasiswa->calculateTotalAndStatus();
        $mahasiswa->save();

        return redirect()->route('mahasiswa.index')
                        ->with('success', 'Mahasiswa created successfully.');
    }

    public function edit(Mahasiswa $mahasiswa)
{
    return response()->json($mahasiswa);
}
    public function show(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.show', compact('mahasiswa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswa,nim,' . $id,
            'prodi' => 'required',
            'angkatan' => 'required',
            'jenis_kelamin' => 'required',
            'tajwid' => 'nullable|numeric',
            'fashohah' => 'nullable|numeric',
            'adab' => 'nullable|numeric',
        ]);

        $mahasiswa = Mahasiswa::find($id);
        $mahasiswa->fill($request->all());
        $mahasiswa->calculateTotalAndStatus();
        $mahasiswa->save();

        return redirect()->route('mahasiswa.index')
                        ->with('success', 'Mahasiswa updated successfully.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa deleted successfully.');
    }

    public function importMahasiswa(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
    ]);

    $file = $request->file('file');
    Excel::import(new MahasiswaImport, $file);

    return redirect()->back()->with('success', 'Data mahasiswa berhasil diimpor.');
}

}
