@extends('admin.layouts.app')

@section('content')

<div class="container-fluid px-4 py-4">
    <h3 class="mb-4">Upload CSV / Excel</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('csv.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        

        <div class="mb-3">
            <label class="form-label">Select CSV File</label>
            <input type="file" name="csv" class="form-control" accept=".csv" required>
        </div>

        <button type="submit" class="btn btn-primary">
            Upload
        </button>
    </form>
</div>

@endsection