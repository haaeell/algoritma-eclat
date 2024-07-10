@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('judul', 'Dashboard')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Data Mahasiswa Tidak Lulus LPBA</h4>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable">
                        <thead>
                            <tr>
                                <th>Angkatan</th>
                                <th>Jumlah Tidak Lulus</th>
                                <th>Total Mahasiswa</th>
                                <th>Persentase Tidak Lulus (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item['angkatan'] }}</td>
                                    <td>{{ $item['jumlah_tidak_lulus'] }}</td>
                                    <td>{{ $item['total_mahasiswa'] }}</td>
                                    <td>{{ $item['persentase_tidak_lulus'] }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Rata-rata Persentase Tidak Lulus</th>
                                <th>{{ $rataRataPersentase }}%</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
