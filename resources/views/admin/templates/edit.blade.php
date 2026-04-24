@extends('admin.layouts.master')

@section('content')
<div class="container">

    <h3>Edit Template</h3>

    <form method="POST" action="{{ route('admin.templates.update',$template->id) }}">
        @csrf
        @method('PUT')

        <div>
            <input type="text" name="name" value="{{ $template->name }}" class="form-control mb-2">
        </div>

        <div>
            <input type="text" name="subject" value="{{ $template->subject }}" class="form-control mb-2">
        </div>

        <div>
            <textarea name="body" class="form-control mb-2">{{ $template->body }}</textarea>
        </div>

        <div>
            <select name="type" class="form-control mb-2">
                <option value="email" {{ $template->type=='email'?'selected':'' }}>Email</option>
                <option value="sms" {{ $template->type=='sms'?'selected':'' }}>SMS</option>
            </select>
        </div>

        <div>
            <button class="btn btn-primary">Update</button>
        </div>

    </form>

</div>
@endsection