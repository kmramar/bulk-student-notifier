@extends('admin.layouts.master')

@section('content')

<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Create Template</h5>
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('admin.templates.store') }}">
                @csrf

                <!-- Title -->
                <div class="mb-3">
                    <label class="form-label">Template Title</label>
                    <input type="text" name="title" placeholder="Example: Admission Email"
                        class="form-control" required>
                </div>

                <!-- Subject -->
                <div class="mb-3">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" placeholder="Enter subject"
                        class="form-control" required>
                </div>

                <!-- Message -->
                <div class="mb-3">
                    <label class="form-label">Message (HTML allowed)</label>
                    <textarea name="message" rows="6"
                   class="form-control"
                      placeholder="Write your template here..." required></textarea>
                    
                    <small class="text-muted">
                        💡 Tip: Use dynamic placeholders like 
                        <b>{name}</b>, <b>{email}</b>, <b>{course}</b>, <b>{roll_number}</b> 
                        to personalize messages automatically.
                    </small>
                </div>

                <!-- Type -->
                <div class="mb-3">
                    <label class="form-label">Template Type</label>
                    <select name="type" class="form-select">
                        <option value="email">Email</option>
                        <option value="sms">SMS</option>
                    </select>
                </div>

                <!-- Button -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success px-4">
                        Save Template
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection