@extends('admin.layouts.master')

@section('content')

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">Edit Template</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.templates.update', $template->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control"
                           value="{{ old('subject', $template->subject) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Message (HTML allowed)</label>
                    <textarea name="message" rows="6" class="form-control">{{ old('message', $template->message) }}</textarea>

                    <small class="text-muted">
                        💡 Tip: Use dynamic placeholders like
                        <b>{name}</b>, <b>{email}</b>, <b>{course}</b>, <b>{roll_number}</b>
                        to personalize messages automatically.
                    </small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Template Type</label>
                    <select name="type" class="form-control">
                        <option value="email" {{ old('type', $template->type) == 'email' ? 'selected' : '' }}>Email</option>
                        <option value="sms" {{ old('type', $template->type) == 'sms' ? 'selected' : '' }}>SMS</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Update Template</button>
                <a href="{{ route('admin.templates.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</div>

@endsection