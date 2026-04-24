@extends('admin.layouts.master')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <h3>Templates</h3>
        <a href="{{ route('admin.templates.create') }}" class="btn btn-success">Add</a>
    </div>

    <div class="card">
        <div class="card-body">

            @foreach($templates as $t)
                <div class="border p-2 mb-2">

                    <div><b>{{ $t->name }}</b></div>
                    <div>{{ $t->subject }}</div>
                    <div>{{ $t->type }}</div>

                    <div class="mt-2">
                        <a href="{{ route('admin.templates.edit',$t->id) }}" class="btn btn-sm btn-primary">Edit</a>

                        <form action="{{ route('admin.templates.destroy',$t->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>

                </div>
            @endforeach

        </div>
    </div>

</div>
@endsection