@extends('admin.layouts.master')

@section('title', 'Edit Student')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <h3 class="mb-4">Edit Student</h3>

            <form action="/admin/students/{{ $student->id }}/update" method="POST">
                @csrf
                

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $student->name }}">
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $student->email }}">
                </div>

                <div class="mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ $student->phone }}">
                </div>

                <div class="mb-3">
                    <label>Course</label>
                    <input type="text" name="course" class="form-control" value="{{ $student->course }}">
                </div>

                <button type="submit" class="btn btn-primary">
                    Update Student
                </button>

                <a href="/admin/students" class="btn btn-secondary">
                    Cancel
                </a>
            </form>

        </div>
    </div>
</div>
@endsection