<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class MahasiswaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $requiredKeys = ['nama', 'nim', 'prodi', 'angkatan', 'jenis_kelamin', 'tajwid', 'fashohah', 'adab'];
        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $row)) {
                throw new \Exception("Kunci array yang dibutuhkan tidak ditemukan: $key");
            }
        }

        $mahasiswa = new Mahasiswa([
            'nama' => $row['nama'],
            'nim' => $row['nim'],
            'prodi' => $row['prodi'],
            'angkatan' => $row['angkatan'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'tajwid' => $row['tajwid'],
            'fashohah' => $row['fashohah'],
            'adab' => $row['adab'],
        ]);

        // Menghitung total dan status
        $mahasiswa->calculateTotalAndStatus();

        return $mahasiswa;
    }
}
