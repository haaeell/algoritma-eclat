@extends('layouts.dashboard')
@section('title', 'Update Configuration')
@section('judul', 'Update Configuration')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Update Configuration</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('proses.updateConfiguration') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="min_support" class="form-label">Minimum Support (%)</label>
                            <input type="number" class="form-control" id="min_support" name="min_support" value="{{ $configuration->min_support ?? 0 }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="min_confidence" class="form-label">Minimum Confidence (%)</label>
                            <input type="number" class="form-control" id="min_confidence" name="min_confidence" value="{{ $configuration->min_confidence ?? 0 }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Configuration</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
