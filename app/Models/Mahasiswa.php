<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $fillable = [
        'nama', 'nim', 'prodi', 'angkatan', 'jenis_kelamin', 
        'tajwid', 'fashohah', 'adab', 'total', 'status'
    ];

    public function calculateTotalAndStatus()
    {
        $this->total = ($this->tajwid * 0.4) + ($this->fashohah * 0.4) + ($this->adab * 0.2);
        
        if ($this->total < 60) {
            $this->status = 'Tidak Lulus (E)';
        } elseif ($this->total >= 60 && $this->total < 70) {
            $this->status = 'Tidak Lulus (D)';
        } elseif ($this->total >= 70 && $this->total < 80) {
            $this->status = 'Lulus (C)';
        } elseif ($this->total >= 80 && $this->total < 90) {
            $this->status = 'Lulus (B)';
        } else {
            $this->status = 'Lulus (A)';
        }
    }
}
