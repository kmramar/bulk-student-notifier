@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Notification Templates</h2>
        <a href="{{ route('admin.templates.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Template
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Template Name</th>
                            <th>Type</th>
                            <th>Audience</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($templates as $t)
                            <tr>
                                <td>
                                    <div class="fw-600">{{ $t->title }}</div>
                                </td>
                                <td>
                                    @if($t->type == 'email')
                                        <span class="badge bg-info">Email</span>
                                    @else
                                        <span class="badge bg-warning">SMS</span>
                                    @endif
                                </td>
                                <td><span class="text-muted">N/A</span></td>
                                <td>{{ $t->subject ?? 'N/A' }}</td>
                                <td>
                                    @if($t->status)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $t->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.templates.edit', $t->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.templates.destroy', $t->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this template?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-layer-group fa-2x mb-3"></i>
                                    <div>No templates found</div>
                                    <a href="{{ route('admin.templates.create') }}" class="btn btn-sm btn-primary mt-2">Create First Template</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection