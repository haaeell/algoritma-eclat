@extends('layouts.dashboard')

@section('title', 'Hasil')

@section('judul', 'Hasil')

@section('content')
    <div class="card shadow border-0">
        <div class="card-header">
            <h4>Hasil Aturan Asosiasi</h4>
        </div>
        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
         @if (empty($rules))
            <div class="alert alert-warning" role="alert">
                Tidak ada data yang sesuai dengan nilai support dan confidence yang diberikan. Silakan coba lagi dengan nilai yang lebih rendah.
            </div>
        @endif

            <div class="mb-3">
                <a href="{{ route('hasil.pdf') }}" class="btn btn-primary">Cetak PDF</a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered  table-hover">
                    <thead>
                        <tr>
                            <th>Rule</th>
                            <th>Support</th>
                            <th>Confidence</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rules as $rule)
                            <tr>
                                <td>{{ $rule['rule'] }}</td>
                                <td>{{ $rule['support'] }}%</td>
                                <td>{{ $rule['confidence'] }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow border-0 text-dark">
        <div class="card-header">
            <h4>Pola yang Terbentuk</h4>
        </div>
        <div class="card-body">

            <div class="list-group">
                @foreach ($patterns as $pattern)
                    <div class="list-group-item">
                        <p>{{ $pattern }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
