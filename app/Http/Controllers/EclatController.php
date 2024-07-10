<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Mahasiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class EclatController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        $configuration = Configuration::first();
        $rules = $this->calculateSupportConfidence($mahasiswa, $configuration->min_support, $configuration->min_confidence);

        $patterns = [];
        $counter = 1;

        if (empty($rules)) {
            $patterns[] = "Tidak ada data yang sesuai dengan nilai support dan confidence yang diberikan. Silakan coba lagi dengan nilai yang lebih rendah.";
        } else {
            foreach ($rules as $rule) {
                // Memecah rule untuk mendapatkan atribut dan nilai
                list($leftPart, $rightPart) = explode(' => ', $rule['rule']);
                list($leftAttr, $leftValue) = explode('=', $leftPart);
                list($rightAttr, $rightValue) = explode('=', $rightPart);
    
                $patterns[] = "Pola {$counter}: Siswa yang mendapatkan nilai " . ucfirst($leftAttr) . " tinggi ({$leftValue}) cenderung juga memiliki nilai " . ucfirst($rightAttr) . " tinggi ({$rightValue}).";
                $counter++;
            }
        }
        return view('hasil', compact('patterns','rules'));
    }

    public function configure()
    {
        $configuration = Configuration::first();
        return view('proses', ['configuration' => $configuration]);
    }

    public function updateConfiguration(Request $request)
    {
        $request->validate([
            'min_support' => 'required|integer|min:0|max:100',
            'min_confidence' => 'required|integer|min:0|max:100'
        ]);

        $configuration = Configuration::first();
        $configuration->update([
            'min_support' => $request->min_support,
            'min_confidence' => $request->min_confidence
        ]);

        return redirect()->route('proses.index')->with('success', 'Configuration updated successfully.');
    }

    public function cetakPdf()
    {
        $mahasiswa = Mahasiswa::all();
        $configuration = Configuration::first();
        $rules = $this->calculateSupportConfidence($mahasiswa, $configuration->min_support, $configuration->min_confidence);
    
        $patterns = [];
        $counter = 1;
    
        if (empty($rules)) {
            $patterns[] = "Tidak ada data yang sesuai dengan nilai support dan confidence yang diberikan. Silakan coba lagi dengan nilai yang lebih rendah.";
        } else {
            foreach ($rules as $rule) {
                list($leftPart, $rightPart) = explode(' => ', $rule['rule']);
                list($leftAttr, $leftValue) = explode('=', $leftPart);
                list($rightAttr, $rightValue) = explode('=', $rightPart);
    
                $patterns[] = "Pola {$counter}: Siswa yang mendapatkan nilai " . ucfirst($leftAttr) . " tinggi ({$leftValue}) cenderung juga memiliki nilai " . ucfirst($rightAttr) . " tinggi ({$rightValue}).";
                $counter++;
            }
        }
    
        $pdf = Pdf::loadView('hasil_pdf', compact('patterns', 'rules'))->setPaper('a4', 'landscape');
    
        return $pdf->download('hasil.pdf');
    }

    private function calculateSupportConfidence($mahasiswa, $minSupport, $minConfidence)
    {
        $itemsets = [];
        $total = count($mahasiswa);


        foreach ($mahasiswa as $data) {
            $itemsets[] = [
                'tajwid' => $data->tajwid,
                'fashohah' => $data->fashohah,
                'adab' => $data->adab
            ];
        }
        $frequentItemsets = [];
        $rules = [];

        // Menghitung support untuk setiap item
        $supportCounts = [];
        foreach ($itemsets as $itemset) {
            foreach ($itemset as $key => $value) {
                if (!isset($supportCounts["{$key}={$value}"])) {
                    $supportCounts["{$key}={$value}"] = 0;
                }
                $supportCounts["{$key}={$value}"]++;
            }
        }



        // Memfilter item berdasarkan minimum support
        foreach ($supportCounts as $item => $count) {
            $support = ($count / $total) * 100;
            if ($support >= $minSupport) {
                $frequentItemsets[$item] = $support;
            }
        }
        // Menghitung confidence untuk setiap aturan
        foreach ($frequentItemsets as $item1 => $support1) {
            foreach ($frequentItemsets as $item2 => $support2) {
                if ($item1 !== $item2) {
                    $count1 = $supportCounts[$item1];
                    $count2 = $supportCounts[$item2];
                    $confidence = ($count2 / $count1) * 100;
                    if ($confidence >= $minConfidence) {
                        $rules[] = [
                            'rule' => "{$item1} => {$item2}",
                            'support' => $support1,
                            'confidence' => $confidence
                        ];
                    }
                }
            }
        }

        return $rules;
    }
}
